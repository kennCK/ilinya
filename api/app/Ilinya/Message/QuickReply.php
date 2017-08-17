<?php

namespace App\Ilinya\Message;

use App\Ilinya\Bot;
use App\Ilinya\Response\Search;

class QuickReply{
  protected $data;
  protected $bot; 
  protected $search;

  function __construct(Bot $bot, $custom, Search $search){
      $this->bot = $bot;
      $this->custom = $custom;
      $this->search = $search;
  }
  public static function manage(){

      switch ($this->currentCode) {
        case $this->code->QR_SEARCH:
          $this->search();
          break;
        case $this->code->PRIORITY_YES: 
          $this->priorityIsYes();
          break;
        case $this->code->PRIORITY_NO:
          $this->priorityIsNo();
          break;
        case $this->code->FORM_CANCEL:
          $this->formIsCancel();
          break;
        case $this->code->FORM_CONTINUE:
          $this->formIsContinue();
          break;
        default:
          //Statement Here
          break;
      }
  }

  public function search(){
      $option = $this->custom['quick_reply']['parameter'];
      $this->searchOption = ($option == "company_name")? 1 : 2;
      $this->bot->reply($this->search->question($option), true);
      $this->stage = $this->code->P_SEARCH;
      $parameter = [
        "stage" => $this->code->P_SEARCH,
        "reply" => 1
      ];
      return $parameter;
  }

  public function priorityIsYes(){
    return 1;
  }

  public function priorityIsNo(){
    return 1;
  }

  public function formIsCancel(){
    return 1;
  }

  public function formIsContinue(){
    return 1;
  }
}