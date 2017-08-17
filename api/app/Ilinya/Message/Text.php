<?php

namespace App\Ilinya\Message;

class Text{
  
  protected $replyStage;

  protected $SEARCH = 1;
  protected $FORM   = 2;
  protected $EDIT   = 3;
  protected $SHORTCODES = 4;

  function __construct($replyStage){
      $this->replyStage = $replyStage;
  }

  public static function manage(){

    switch ($this->replyStage) {
      case $this->SEARCH:
        $this->search();
        break;
      case $this->FORM:
        $this->form();
        break;
      case $this->EDIT:
        $this->edit();
        break;
      case $this->SHORTCODES:
        $this->shortCodes();
        break;
      default:
        $this->error();
        break;
    }


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