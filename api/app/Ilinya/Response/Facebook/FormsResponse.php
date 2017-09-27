<?php

namespace App\Ilinya\Response\Facebook;
/*
    @Providers
*/
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\User;
use App\Ilinya\Tracker;
use Illuminate\Http\Request;
/*
    @Template
*/
use App\Ilinya\Templates\Facebook\QuickReplyTemplate;
use App\Ilinya\Templates\Facebook\ButtonTemplate;
use App\Ilinya\Templates\Facebook\GenericTemplate;
use App\Ilinya\Templates\Facebook\LocationTemplate;
use App\Ilinya\Templates\Facebook\ListTemplate;

/*
    @Elements
*/

use App\Ilinya\Templates\Facebook\ButtonElement;
use App\Ilinya\Templates\Facebook\GenericElement;
use App\Ilinya\Templates\Facebook\QuickReplyElement;


/*
    @API
*/
use App\Ilinya\API\Controller;

class FormsResponse{
  protected $messaging;
  protected $tracker;
  protected $curl;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->tracker   = new Tracker($messaging);
      $this->curl = new Curl();
  }

  public function user(){
      $user = $this->curl->getUser($this->messaging->getSenderId());
      $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
  }

  public function selectForms($forms){
      return ['text'  => "Select form:"];
  }

 public function confirmation($form){
      $this->user();
      $companyData = $this->tracker->getCompanyData();
      $title = "Hi ".$this->user->getFirstName()." :) You are about to get ".$companyData[0]['name'].' '.$form['title'].' Form. Are you sure you want to continue?';
      $quickReplies[] = QuickReplyElement::title('No')->contentType('text')->payload($form['id'].'@qrFormCancel');
      $quickReplies[] = QuickReplyElement::title('Yes')->contentType('text')->payload($form['id'].'@qrFormContinue');
      return QuickReplyTemplate::toArray($title, $quickReplies);
  }

  public function emptyForm(){
    return ['text'  => 'No Forms Available'];
  }

  public function ask($question){
    return ['text' => $question];
  }

  public function error(){
    $this->user();
    return ['text' => 'Hi '.$this->user->getFirstName().', I am very sorry but you have missed something. I will take you form the start. Kindly select the options below.'];
  }

  public function duplicate(){
    $this->user();
    return ['text' => "Hi ".$this->user->getFirstName().", You're QCard is still active."];
  }

}