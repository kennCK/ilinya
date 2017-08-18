<?php

namespace App\Ilinya\Message;

use App\Ilinya\Bot;
use App\Ilinya\StatusChecker;
use App\Ilinya\Message\Codes;
use App\Ilinya\Response\Forms;
use App\Ilinya\Response\PostbackResponse;
use App\Ilinya\Response\CategoryResponse;
use App\Ilinya\Webhook\Messaging;


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
        $this->form   = new Forms($messaging);
        $this->tracker= new StatusChecker($messaging);
        $this->code   = new Codes(); 
  }
  public function manage($custom){
      $parameter = $custom['quick_reply']['parameter'];
      switch ($this->code->getCode($custom)) {
        case $this->code->qrSearch:
          $this->bot->reply($this->category->question($parameter),true);
          break;
        case $this->code->qrPriorityYes:
          break;
        case $this->code->qrPriorityNo:
          break;
        case $this->code->qrFormCancel:
          break;
        case $this->code->qrFormContinue:
          break;
        default:
          //Statement Here
          break;
      }
  }
}