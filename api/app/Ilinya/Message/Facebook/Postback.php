<?php

namespace App\Ilinya\Message\Facebook;

use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Response\Facebook\FormsResponse;
use App\Ilinya\Response\Facebook\PostbackResponse;
use App\Ilinya\Response\Facebook\CategoryResponse;
use App\Ilinya\Webhook\Facebook\Messaging;

class Postback{
    protected $forms;
    protected $post;
    protected $search;
    protected $code;
    protected $tracker;
    function __construct(Messaging $messaging){
        $this->bot    = new Bot($messaging);
        $this->post   = new PostbackResponse($messaging);
        $this->category = new CategoryResponse($messaging);
        $this->forms   = new FormsResponse($messaging);
        $this->tracker= new Tracker($messaging);
        $this->code   = new Codes(); 
    }

    public function manage($custom){
        $action = $this->code->getCode($custom);
        switch ($action) {
          case $this->code->pStart:
            $this->bot->reply($this->post->start(), true);
            $this->bot->reply($this->post->categories(), false);
            break;
          case $this->code->pUserGuide:
            $this->bot->reply($this->post->userGuide(), true);
            break;
          case $this->code->pMyQueueCards:
            $this->bot->reply($this->post->myQueueCards(), true);
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
            $this->bot->reply($this->forms->retrieve($custom['parameter']), false);
            break;
          case $this->code->pLocate:
            //Do Something
            break;
          case $this->code->pNext:
            //Do Something
            break;
          case $this->code->pSend:
            //Do Something
            break;
          case $this->code->pEdit:
            //Do Something
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