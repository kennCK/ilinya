<?php

namespace App\Ilinya\Message\Facebook;

use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Message\Facebook\Form;
use App\Ilinya\Response\Facebook\PostbackResponse;
use App\Ilinya\Response\Facebook\CategoryResponse;
use App\Ilinya\Response\Facebook\SendResponse;
use App\Ilinya\Response\Facebook\EditResponse;
use App\Ilinya\Response\Facebook\QueueCardsResponse;
use App\Ilinya\Webhook\Facebook\Messaging;

class Postback{
    protected $forms;
    protected $post;
    protected $search;
    protected $code;
    protected $tracker;
    protected $send;
    protected $edit;
    protected $qc;
    function __construct(Messaging $messaging){
        $this->bot    = new Bot($messaging);
        $this->post   = new PostbackResponse($messaging);
        $this->category = new CategoryResponse($messaging);
        $this->forms   = new Form($messaging);
        $this->tracker= new Tracker($messaging);
        $this->code   = new Codes(); 
        $this->send   = new SendResponse($messaging);
        $this->edit   = new EditResponse($messaging);
        $this->qc     = new QueueCardsResponse($messaging);
    }

    public function manage($custom){
        $action = $this->code->getCode($custom);
        switch ($action) {
          case $this->code->pStart:
            $this->bot->reply($this->post->start(), false);
            $this->bot->reply($this->post->categories(), false);
            break;
          case $this->code->pUserGuide:
            $this->bot->reply($this->post->userGuide(), true);
            break;
          case $this->code->pMyQueueCards:
            $this->bot->reply($this->qc->display(), false);
            break;
          case $this->code->pCategories:
            $this->bot->reply($this->post->categories(), false);
            break;
          case $this->code->pCategorySelected:
            $this->bot->reply($this->category->companies($custom['parameter']), false);
            break;
          case $this->code->pSearch:
            $this->bot->reply($this->category->searchOption(), false);
            break;
          case $this->code->pGetQueueCard:
            $this->forms->retrieveForms($custom['parameter']);
            break;
          case $this->code->pLocate:
            //Do Something
            break;
          case $this->code->pNext:
            //Do Something
            break;
          case $this->code->pSend:
            $this->bot->reply($this->send->submit(), false);
            break;
          case $this->code->pEdit:
            $this->bot->reply($this->edit->manage($custom), false);
            break;
          case $this->code->pDisregard:
            //Do Something
            break;
          default:
            //Error
            break;
        }   
    }
}