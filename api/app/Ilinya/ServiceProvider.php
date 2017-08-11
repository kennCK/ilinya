<?php
namespace App\Ilinya;

use App\Ilinya\Http\Curl;
use App\Ilinya\Bot;
use App\Ilinya\Ilinya;
use App\Ilinya\StatusChecker;
use App\Ilinya\Message\Attachments;
use App\Ilinya\Webhook\Messaging;


/*
    @Coversation
*/

use App\Ilinya\Conversation\SearchCompany;
use App\Ilinya\Conversation\Conversation;

class ServiceProvider{
  protected $curl;
  protected $messaging;
  protected $bot;
  protected $ilinya;
  protected $custom;
  protected $checker;

  function __construct(Messaging $messaging){
    $this->curl = new Curl();
    $this->bot = new Bot($messaging);
    $this->ilinya = new Ilinya($messaging); 
    $this->custom = $this->bot->extractData();
    $this->checker = new StatusChecker($messaging);
  }

  public function manage(){       
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
  }

  public function postback(){
        list($priority, $category) = explode('@', $this->custom['payload']);
        $status = $this->checker->getStatus();

            if($this->custom['payload'] == $this->ilinya->GET_STARTED){
                if($status < 140){
                  $this->bot->reply($this->ilinya->start(), true);
                  $this->bot->reply($this->ilinya->categories(), false);
                  $this->checker->insert(130);
                }
                else{
                  $this->bot->reply($this->ilinya->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->ilinya->CATEGORIES){
                if($status < 140){
                  $this->bot->reply($this->ilinya->categories(), false);
                  $this->checker->update(130);
                }
                else{
                  $this->bot->reply($this->ilinya->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->ilinya->MY_QUEUE_CARDS){
                if($status < 140){
                  $this->bot->reply($this->ilinya->myQueueCards(), true);
                  $this->checker->update(120);
                }
                else{
                  $this->bot->reply($this->ilinya->priority(), false);
                }
            }
            else if($this->custom['payload'] == $this->ilinya->USER_GUIDE){
                if($status < 140){
                  $this->bot->reply($this->ilinya->userGuide(), true);
                  $this->checker->update(110);
                }
                else{
                  $this->bot->reply($this->ilinya->priority(), false);
                }
            }
            else if($priority == 'categories'){
                if($status < 140)
                  $this->bot->reply($this->ilinya->search($category), false);
                else{
                  $this->bot->reply($this->ilinya->priority(), false);
                }
            }
            else{
                $this->bot->reply($this->ilinya->ERROR, true);
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
                $response = $this->ilinya->location($attachments);
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