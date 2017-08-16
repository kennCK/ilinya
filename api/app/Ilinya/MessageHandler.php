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
use App\Ilinya\Response\Forms;


class MessageHandler{
  protected $checker;
  protected $response;
  protected $bot;
  protected $custom;
  protected $search;

  protected $types = array('postback', 'message', 'read', 'delivery');

  protected $code;

  protected $currentCode;

  protected $reply;

  protected $searchOption;

  protected $stage;

  protected $companyId;

  protected $category;

  function __construct(Messaging $messaging){
    $this->checker    = new StatusChecker($messaging);
    $this->response   = new Introduction($messaging); 
    $this->search     = new Search($messaging);
    $this->forms      = new Forms($messaging, $this->checker);
    $this->bot        = new Bot($messaging);
    $this->code       = new Codes();
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
  }

  public function checkMessage(){
    $stage = $this->code->P_START;
    $dbTrack = 0;
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
        $this->getParameter();    
        break;
      case 2001:  
        $this->postback();
        $dbTrack = 2;
        $this->getParameter();    
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
    if($dbTrack == 1){
        //Create
        $this->checker->insert($this->currentCode, $stage, $this->category);
    }
    else if($dbTrack == 2 && $this->currentCode != $this->code->M_TEXT){
        $data = [
            "status"            => $this->currentCode
        ];
        if($this->reply)$data['reply']  = $this->reply;
        if($this->searchOption)$data['search_option'] = $this->searchOption;
        if($this->category)$data['business_type_id'] =  $this->category;
        if($this->stage)$data['stage'] = $this->stage;
        if($this->companyId)$data['company_id'] = $this->companyId;
        $this->checker->update($data);
    }
    else if($dbTrack == 2 && $this->currentCode == $this->code->M_TEXT){
        $data['reply']  = $this->reply;
        $this->checker->update($data);
    }
  }

  public function getParameter(){

    switch ($this->custom['payload']) {
      case '@categoryselected':
        $this->category =  $this->custom['parameter'];
        break;
      case '@get_queue_cards':
        $this->companyId = $this->custom['parameter'];
        break;
      default:
        # code...
        break;
    }
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
            case $this->code->P_GET_GC:
              $this->bot->reply($this->forms->retrieve(), false);
              break;
            case $this->code->P_LIMIT:
              $this->bot->reply("Shutdown", true);
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
            $this->replyHandler();
            
        } 
  }


  public function quickReply(){
      $this->reply = 1;
      switch ($this->currentCode) {
        case $this->code->QR_SEARCH:
          $option = $this->custom['quick_reply']['parameter'];
          $this->searchOption = ($option == "company_name")? 1 : 2;
          $this->bot->reply($this->search->question($option), true);
          $this->stage = $this->code->P_SEARCH;
          break;
        case '@priority':
          //Statement Here
          break;
        default:
          //Statement Here
          break;
      }
  }

  public function replyHandler(){
    $text = $this->custom['text'];
    $replyStatus = $this->checker->getReply();
    if($replyStatus == 1){
      $response = $this->search->handler($this->custom['text'], $this->checker);
      $this->bot->reply($response, false);
    }
    else{
      $this->bot->reply($this->response->ERROR, true);
    }
    $this->reply = 0;
  }
  public function read(){
      //
  }

  public function delivery(){
      //
  }
  
}