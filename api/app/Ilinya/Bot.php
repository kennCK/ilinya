<?php

namespace App\Ilinya;


use Illuminate\Support\Facades\Log;

use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Facebook\Messaging;


class Bot{  
  
    private     $messaging;
    protected   $curl;

    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
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