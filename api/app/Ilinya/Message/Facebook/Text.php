<?php

namespace App\Ilinya\Message\Facebook;

use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Message\Facebook\Form;
use App\Ilinya\Response\Facebook\PostbackResponse;
use App\Ilinya\Response\Facebook\CategoryResponse;
use App\Ilinya\Response\Facebook\EditResponse;
use App\Ilinya\Response\Facebook\SearchResponse;
use App\Ilinya\Webhook\Facebook\Messaging;

class Text{
    protected $form;
    protected $post;
    protected $search;
    protected $code;
    protected $tracker;
    protected $edit;

  function __construct(Messaging $messaging){
      $this->bot    = new Bot($messaging);
      $this->post   = new PostbackResponse($messaging);
      $this->category = new CategoryResponse($messaging);
      $this->form   = new Form($messaging);
      $this->tracker= new Tracker($messaging);
      $this->code   = new Codes(); 
      $this->edit   = new EditResponse($messaging);
      $this->search = new SearchResponse($messaging);
  }

  public function manage($reply){
    $shortCodes = $this->checkShortCodes($reply);
    if($shortCodes == true){
      //Short Codes
    }
    else{
        switch ($this->tracker->getReplyStage()) {
          case $this->code->replyStageSearch:
            $this->bot->reply($this->post->informAboutQCard(), false);
            $this->bot->reply($this->search->manage($reply), false);
            break;
          case $this->code->replyStageForm:
            $this->form->reply($reply);
            break;
          case $this->code->replyStageEdit:
            /*
              1. Validate
              2. Check
            */
            $validate = $this->edit->validate($reply);
            if($validate['status'] == true){
              $this->bot->reply($this->edit->inform(), false);
              $this->bot->reply($this->edit->update($reply), false);
            }
            else{
              $this->bot->reply('Please enter a valid '.$validate['type'].'! '.$validate['description'], true);
            }
            break;
          case $this->code->replyStageShortCodes:
            $this->shortCodes();
            break;
          default:
            $this->error();
            break;
        }  
    }
  }
  public function checkShortCodes($text){
    if($text[0] == '@'){
      return true;
    }
    return false;
  }

  public function form(){

  }

  public function shortCodes(){

  }

  public function error(){

  }
}