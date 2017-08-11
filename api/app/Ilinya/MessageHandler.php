<?php
namespace App\Ilinya;

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

  function __construct(Messaging $messaging){
    $this->checker    = new StatusChecker($messaging);
    $this->response   = new ResponseHandler($messaging); 
    $this->bot        = new Bot($messaging);
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
  }

  public function manage(){
    //Save Tracker
        if($this->custom['type'] == "postback"){
          $this->postback();
        }
        else if($this->custom['type'] == "message"){
          $this->message();
        }
        else if($this->custom['type'] == "read"){
          $this->read();
        }
        else if($this->custom['type'] == "delivery"){
          $this->delivery();
        }
    //Update Tracker
  }

  public function postback(){
        list($priority, $category) = explode('@', $this->custom['payload']);
        $status = $this->checker->getStatus();

            if($this->custom['payload'] == $this->response->GET_STARTED){
                if($status < 140){
                  $this->bot->reply($this->response->start(), true);
                  $this->bot->reply($this->response->categories(), false);
                  $this->checker->insert(130);
                }
                else{
                  $this->bot->reply($this->response->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->response->CATEGORIES){
                if($status < 140){
                  $this->bot->reply($this->response->categories(), false);
                  $this->checker->update(130);
                }
                else{
                  $this->bot->reply($this->response->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->response->MY_QUEUE_CARDS){
                if($status < 140){
                  $this->bot->reply($this->response->myQueueCards(), true);
                  $this->checker->update(120);
                }
                else{
                  $this->bot->reply($this->response->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->response->USER_GUIDE){
                if($status < 140){
                  $this->bot->reply($this->response->userGuide(), true);
                  $this->checker->update(110);
                }
                else{
                  $this->bot->reply($this->response->priority(), false);
                }
            }
            else if($priority == 'categories'){
                if($status < 140)
                  $this->bot->reply($this->response->search($category), false);
                else{
                  $this->bot->reply($this->response->priority(), false);
                }
            }
            else{
                $this->bot->reply($this->response->ERROR, true);
            }
  }

  public function message(){
        /*
            @Check if Message Contains Attachments, Quick Reply or Text
        */

        $response = "";
        if($this->custom['attachments']){
            /*
                @Check type of attachments
            */
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
    $status = $this->checker->getStatus();
    if($type == "search"){
      $this->bot->reply(SearchCompany::search($value), true);
    }
    else if($type == "priority"){
      if($value == "yes"){
        $this->checker->delete();
      }
      else{

      }

    }
    else{

    }
  }
  public function read(){
    //
  }

  public function delivery(){
    //
  }
  
}