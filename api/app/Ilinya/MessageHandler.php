<?php
namespace App\Ilinya;

use App\Ilinya\Message\Codes;
use App\Ilinya\Message\Attachments;
use App\Ilinya\Bot;
use App\Ilinya\StatusChecker;
use App\Ilinya\MessageExtractor;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Response\Introduction;
use App\Ilinya\Response\Search;


class MessageHandler{
  protected $checker;
  protected $response;
  protected $bot;
  protected $custom;
  protected $search;

  protected $types = array('postback', 'message', 'read', 'delivery');

  protected $code;

  protected $currentCode;

  function __construct(Messaging $messaging){
    $this->checker    = new StatusChecker($messaging);
    $this->response   = new Introduction($messaging); 
    $this->search     = new Search($messaging);
    $this->bot        = new Bot($messaging);
    $this->code       = new Codes();
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
  }

  public function checkMessage(){
    //Save tracker here
    $category = null;
    $dbTrack = 0;
    //echo json_encode($this->custom);
    $status = $this->checker->getStatus($this->custom);
    $this->currentCode = $this->code->getCodeByUnknown($this->custom);
    switch ($status) {
      case 0:
        $this->read();
        break;
      case 1000:
        $this->delivery();
        break;
      case 2000:
        $this->postback();
        $dbTrack = 1;
        $category = $this->getCategoryIfExist();    
        break;
      case 2001:  
        $this->postback();
        $dbTrack = 2;
        $category = $this->getCategoryIfExist();    
        break;
      case 3000:
        $this->message();
        $dbTrack = 2;
        break;
      case 4000:
        $this->bot->reply($this->response->priorityError(), false);
        break;
      default:
        //
        break;
    }
    if($dbTrack == 1)
        $this->checker->insert($this->currentCode, $category);
    else if($dbTrack == 2 && $this->currentCode != $this->code->M_TEXT)
        $this->checker->update($this->currentCode, $category);
  }

  public function getCategoryIfExist(){
    if($this->custom['payload'] == '@categoryselected')
          return $this->custom['parameter'];
    else
          return null;
  }

  public function postback(){
          $action = $this->code->getCode($this->custom['payload']);
          switch ($action) {
            case $this->code->P_START:
              $this->bot->reply($this->response->start(), true);
              $this->bot->reply($this->response->categories(), false);
              break;
            case $this->code->P_USERGUIDE:
              $this->bot->reply($this->response->userGuide(), true);
              break;
            case $this->code->P_QUEUECARDS:
              $this->bot->reply($this->response->myQueueCards(), true);
              break;
            case $this->code->P_CATEGORIES:
              $this->bot->reply($this->response->categories(), false);
              break;
            case $this->code->P_CATEGORY_SELECTED:
              $this->bot->reply($this->search->options(), false);
              break;
            default:
              $this->bot->reply($this->response->ERROR, true);
              break;
          }   
  }

  public function message(){
        $response = "";
        if($this->custom['attachments']){
            $attachments = new Attachments($this->custom['attachments']);
            $response;
            if($attachments->getType() == "location"){
                $response = $this->response->location($attachments);
            }
            else{
            }
            $this->bot->reply($response, true);
        }
        else if($this->custom['quick_reply']){
            $this->quickReply();
        }
        else if($this->custom['text']){
            $this->bot->reply($this->custom['text'], true);
        } 
  }


  public function quickReply(){
      switch ($this->currentCode) {
        case $this->code->QR_SEARCH:
          $this->bot->reply($this->search->question($this->custom['quick_reply']['parameter']), true);
          break;
        case '@priority':
          //Statement Here
          break;
        default:
          //Statement Here
          break;
      }
  }
  public function read(){
      //
  }

  public function delivery(){
      //
  }
  
}