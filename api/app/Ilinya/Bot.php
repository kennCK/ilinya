<?php

namespace App\Ilinya;

use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Webhook\Message;
use Illuminate\Support\Facades\Log;
use App\Ilinya\ServiceProvider;

use App\Ilinya\Http\Curl;


class Bot{  
  
    private     $messaging;
    protected   $curl;

    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
    }

    public function extractData(){
        $type = $this->messaging->getType();
        if($type == "message") {
            return $this->extractDataFromMessage();
        } 
        else if ($type == "postback") {
            return $this->extractDataFromPostback();
        }
        else if($type == "read"){
            return $this->extractDataFromRead();
        }
        else if($type == "delivery"){
            return $this->extractDataFromDelivery();
        }
        return [];
    }

    public function extractDataFromMessage(){
        $message = new Message($this->messaging->getMessageArray());
        return [
            "type"          => "message",
            "text"          => $message->getText(),
            "attachments"    => $message->getAttachments(),
            "quick_reply"   => $message->getQuickReply()
        ];
    }

    public function extractDataFromPostback(){
        $payload = $this->messaging->getPostback()->getPayload();
        return [
            "type"      => "postback",
            "payload"   => $payload
        ];
    }

    public function extractDataFromRead(){
        return [
            "type"  => "read"
        ];
    }

    public function extractDataFromDelivery(){
        return [
            "type"  => "delivery"
        ];
    }

    public function reply($data, $flag){
        $message = ($flag == true)?["text" => $data] : $data;
        $this->send($message);
    }

    public function ask($question){
        $message = ['text' => $question];
        $this->send($message);
    }

    public function send($message){
        $id = $this->messaging->getSenderId();
        $this->curl->send($id, $message);
    }

}