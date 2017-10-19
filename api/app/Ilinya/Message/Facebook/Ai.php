<?php

namespace App\Ilinya\Message\Facebook;

use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use App\Ilinya\Http\Curl;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Message\Facebook\Form;
use App\Ilinya\Message\Facebook\Postback;
use App\Ilinya\Message\Facebook\QuickReply;
use App\Ilinya\Response\Facebook\AiResponse;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\Helper\Validation;
use App\Ilinya\API\QueueCardFields;
use App\Ilinya\API\Ai as AiResponseManager;
use App\Ilinya\User;
class Ai{

    protected $bot;
    protected $form;
    protected $tracker;
    protected $code;
    protected $validation;
    protected $aiResponse;
    protected $postback;
    protected $quickReply;
    protected $curl;
    protected $user;
    protected $messaging;

  function __construct(Messaging $messaging){
      $this->bot    = new Bot($messaging);
      $this->form   = new Form($messaging);
      $this->tracker= new Tracker($messaging);
      $this->code   = new Codes(); 
      $this->validation = new Validation($messaging);
      $this->aiResponse   = new AiResponse($messaging);
      $this->postback = new Postback($messaging);
      $this->quickReply = new QuickReply($messaging);
      $this->curl   = new Curl();
      $this->messaging = $messaging;
  }
  
  public function user(){
      $user = $this->curl->getUser($this->messaging->getSenderId());
      $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
  }

  public function manage($reply){

    /*
      1. get result
      2. if result, check action
        2.1 action is null, reply text
        2.2 action is not null, manage action
      3. else result, reply error

    */
    $reply = strtolower($reply);
    $data = [
      "column"  => "question",
      "clause"  => "like",
      "value"   => $reply
    ];
    $result = AiResponseManager::retrieve($data);

    if($result){
      /*
        1. Get Code
        2. Manage code
      */
      if($result[0]['answer'] != NULL){
        $this->answerHandler($result[0]['answer']);
      }
      if($result[0]['action'] != NULL){
        $this->actionTypeHandler($result[0]);
      }
    }else{
      $dataError = [
        "column"  => "question",
        "clause"  => "=",
        "value"   => "not_found"
      ];
      $errorResult = AiResponseManager::retrieve($dataError);
      $this->saveNewQuestion($reply);
      if($errorResult){
        $this->bot->reply($errorResult[0]['answer'], true);
      }else{
        $this->bot->reply("We're working to be able to respond your concern :)", true);
      }
    }
  }

  public function actionTypeHandler($object){
    switch (strtolower($object['action_type'])) {
      case 'postback':
        $custom = [
          "type"      => "postback",
          "payload"   => $object['action'],
          "parameter" => NULL
        ];
        $this->postback->manage($custom);
        break;
      case 'quick_reply':
        $custom = [
          "type"        => "messaging",
          "quick_reply" => array(
            "payload"   => $object['action'],
            "parameter" => NULL
          ),
          "text"        => NULL,
          "attachment"  => NULL
        ];
        $this->quickReply->manage($custom);
        break;
    }
  }

  public function answerHandler($text){
    if(strpos($text, '%') != false){
      $answer = explode('%', $text, -1);
      if(sizeof($answer) > 1){
        $responseText = '';
        for($row = 0; $row < sizeof($answer); $row++){
          $responseText .=$this->codeHandler($answer[$row]);
        }
        $this->bot->reply($responseText, true);
      }else{
        $this->bot->reply($text, true);
      }
    }else{
      $this->bot->reply($text, true);
    }
  }

  public function codeHandler($text){
    $response = '';
    switch (strtolower($text)) {
      case '@fname':
        $this->user();
        return $this->user->getFirstName();
      case '@lname':
        $this->user();
       return $this->user->getLastName();
      case '@cname':
        $this->user();
        return $this->user->getFirstName()." ".$this->user->getLastName();
      default:
        return $text;
    }
  }
  public function saveNewQuestion($text){
    // save to ai here
    $data = [
      "question"  => $text
    ];

    return AiResponseManager::create($data);
  }

}
