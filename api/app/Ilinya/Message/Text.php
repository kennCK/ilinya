<?php

namespace App\Ilinya\Message;

use App\Ilinya\Bot;
use App\Ilinya\StatusChecker;
use App\Ilinya\Message\Codes;
use App\Ilinya\Response\Forms;
use App\Ilinya\Response\PostbackResponse;
use App\Ilinya\Response\CategoryResponse;
use App\Ilinya\Webhook\Messaging;

class Text{
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

  public static function manage($custom){
    $shortCodes = $this->checkShortCodes($custom['text']);
    if($shortCodes == true){
      //Short Codes
    }
    else{
        switch ($this->replyStage) {
          case $this->code->replyStageSearch:
            $this->bot->reply($custom['text'], true);
            //$this->search();
            break;
          case $this->code->replyStageForm:
            $this->form();
            break;
          case $this->code->replyStageEdit:
            $this->edit();
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

  public function search(){

  }

  public function form(){

  }

  public function edit(){

  }

  public function shortCodes(){

  }

  public function error(){

  }
}