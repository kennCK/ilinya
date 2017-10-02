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
use App\Ilinya\Response\Facebook\EditDetailsResponse;
use App\Ilinya\Response\Facebook\DetailsResponse;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\Helper\Validation;
use App\Ilinya\API\QueueCardFields;

class Text{
    protected $form;
    protected $post;
    protected $search;
    protected $code;
    protected $tracker;
    protected $edit;
    protected $editDetails;
    protected $validation;
    protected $details;
  function __construct(Messaging $messaging){
      $this->bot    = new Bot($messaging);
      $this->post   = new PostbackResponse($messaging);
      $this->category = new CategoryResponse($messaging);
      $this->form   = new Form($messaging);
      $this->tracker= new Tracker($messaging);
      $this->code   = new Codes(); 
      $this->edit   = new EditResponse($messaging);
      $this->search = new SearchResponse($messaging);
      $this->editDetails = new EditDetailsResponse($messaging);
      $this->validation = new Validation($messaging);
      $this->details = new DetailsResponse($messaging);
  }

  public function manage($reply){
    $shortCodes = $this->checkShortCodes($reply);
    if($shortCodes == true){
      //Short Codes
    }
    else{
        switch ($this->tracker->getReplyStage()) {
          case $this->code->replyStageSearch:
            if(intval($this->tracker->getSearchOption()) >= 2){
              $this->bot->reply($this->search->manage($reply), false);
            }
            else{
              $this->bot->reply($this->search->manageSearchByCode($reply), false);
            }   
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
              $this->bot->reply('Sorry you have entered an invalid '.$validate['type']." :'( Again, ".$validate['description'], true);
            }
            break;
          case $this->code->replyEditDetails:
            /*
              1. Validate
              2. Check
            */
            $validate = $this->validation->validate($reply);
            if($validate['status'] == true){
              $data = [
                  "column"  => "id",
                  "value"   => $this->tracker->getEditFieldId()
              ];
              $qCardId = QueueCardFields::retrieveByCustom($data, "queue_card_id");
              $this->bot->reply($this->editDetails->update($reply), false);
              $this->bot->reply($this->details->viewDetails($qCardId), false);
            }
            else{
              $this->bot->reply('Sorry you have entered an invalid '.$validate['type']." :'( Again, ".$validate['description'], true);
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