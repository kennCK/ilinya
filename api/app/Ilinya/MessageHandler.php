<?php
namespace App\Ilinya;

use App\Ilinya\Message\Codes;
use App\Ilinya\Bot;
use App\Ilinya\ResponseHandler;
use App\Ilinya\StatusChecker;
use App\Ilinya\MessageExtractor;
use App\Ilinya\Webhook\Messaging;


class MessageHandler{
  protected $checker;
  protected $response;
  protected $bot;
  protected $custom;

  protected $types = array('postback', 'message', 'read', 'delivery');

  protected $code;

  function __construct(Messaging $messaging){
    $this->checker    = new StatusChecker($messaging);
    $this->response   = new ResponseHandler($messaging); 
    $this->bot        = new Bot($messaging);
    $this->code       = new Codes();
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
  }

  public function checkMessage(){
    //Save tracker here
    $status = $this->checker->getStatus($this->custom);
    switch ($status) {
      case 0:
        $this->read();
        break;
      case 1000:
        $this->delivery();
        break;
      case 2000:
        $this->postback();
        $this->checker->insert($this->code->getCodeByUnknown($this->custom));
        break;
      case 2001:
        $this->postback();
        $this->checker->update($this->code->getCodeByUnknown($this->custom));
        break;
      case 3000:
        $this->message();
        $this->checker->update($this->code->getCodeByUnknown($this->custom));
        break;
      case 4000:
        $this->bot->reply($this->response->priorityError(), false);
        break;
      default:
        //
        break;
    }
  }

  public function postback(){
        list($priority, $category) = explode('@', $this->custom['payload']);
        if(!$priority){
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
            default:
              $this->bot->reply($this->response->ERROR, true);
              break;
          }
        }
        else{
          switch ($priority) {
            case 'categories':
              $this->bot->reply($this->response->search($category), false);
              break;
            default:
              $this->bot->reply($this->response->ERROR, true);
              break;
          }
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
      list($type, $value) = explode('@', $this->custom['quick_reply']['payload']);

      switch ($type) {
        case 'search':
          $this->bot->reply(SearchCompany::search($value), true);
          break;
        case 'priority':
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