<?php
namespace App\Ilinya;

use App\Ilinya\Http\Curl;
use App\Ilinya\Bot;
use App\Ilinya\Ilinya;
use App\Ilinya\Message\Attachments;
use App\Ilinya\Webhook\Messaging;

class ServiceProvider{
  protected $curl;
  protected $messaging;
  protected $bot;
  protected $ilinya;
  protected $custom;

  function __construct(Messaging $messaging){
    $this->curl = new Curl();
    $this->bot = new Bot($messaging);
    $this->ilinya = new Ilinya($messaging); 
    $this->custom = $this->bot->extractData();
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

            if($this->custom['payload'] == $this->ilinya->GET_STARTED){
                $this->bot->reply($this->ilinya->start(), true);
                $this->bot->reply($this->ilinya->categories(), false);
            }
            else if($this->custom['payload'] == $this->ilinya->CATEGORIES){
                $this->bot->reply($this->ilinya->categories(), false);
            }
            else if($this->custom['payload'] == $this->ilinya->MY_QUEUE_CARDS){
                $this->bot->reply($ilinya->myQueueCards(), true);
            }
            else if($this->custom['payload'] == $this->ilinya->USER_GUIDE){
               $this->bot->reply($this->ilinya->userGuide(), true);
            }
            else if($priority == 'categories'){
                $this->bot->reply($this->ilinya->conversation($category), false);
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
            $this->bot->reply($response, false);
        }
        else if($this->custom['quick_reply']){
            $this->bot->reply();  
        }
        else if($this->custom['text']){
            $this->bot->reply($this->custom['text'], true);
        } 
  }

  public function read(){
    //
  }

  public function delivery(){
    //
  }
  
}