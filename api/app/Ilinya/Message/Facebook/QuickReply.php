<?php

namespace App\Ilinya\Message\Facebook;

use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Message\Facebook\FormControl;
use App\Ilinya\Response\Facebook\PostbackResponse;
use App\Ilinya\Response\Facebook\CategoryResponse;
use App\Ilinya\Webhook\Facebook\Messaging;


class QuickReply{
    protected $form;
    protected $post;
    protected $search;
    protected $code;
    protected $tracker;

  function __construct(Messaging $messaging){
        $this->bot    = new Bot($messaging);
        $this->post   = new PostbackResponse($messaging);
        $this->category = new CategoryResponse($messaging);
        $this->form   = new FormControl($messaging);
        $this->tracker= new Tracker($messaging);
        $this->code   = new Codes(); 
  }
  public function manage($custom){
      $parameter = $custom['quick_reply']['parameter'];
      switch ($this->code->getCode($custom)) {
        case $this->code->qrSearch:
          $this->bot->reply($this->category->question($parameter),true);
          return null;
          break;
        case $this->code->qrPriorityYes:
          break;
        case $this->code->qrPriorityNo:
          break;
        case $this->code->qrFormCancel:
          $this->bot->reply($this->post->categories(), false);
          return null;
          break;
        case $this->code->qrFormContinue:
          $this->form->retrieveFields();
          return [
            "form_id" => $parameter,
            "stage"     => $this->code->stageForm
          ];
          break;
        default:
          //Statement Here
          break;
      }
  }
}