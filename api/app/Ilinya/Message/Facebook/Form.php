<?php
namespace App\Ilinya\Message\Facebook;


use App\Ilinya\Bot;
use App\Ilinya\Tracker;
use Illuminate\Http\Request;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Response\Facebook\FormsResponse;
use App\Ilinya\Response\Facebook\PostbackResponse;
use App\Ilinya\Webhook\Facebook\Messaging;
/*
    @API
*/
use App\Ilinya\API\Controller;

class Form{

  public    $question;
  public    $reply;
  protected $messaging;
  protected $bot;
  protected $response;
  protected $tracker;
  protected $code;
  protected $post;

  function __construct(Messaging $messaging){
    $this->messaging  = $messaging;
    $this->bot        = new Bot($messaging);
    $this->response   = new FormsResponse($messaging);
    $this->tracker    = new Tracker($messaging);
    $this->code       = new Codes();
    $this->post       = new PostbackResponse($messaging);
  }

 public function retrieveForms($companyId){
    $request = new Request();
    $condition[] = [
      "column"  => "company_id",
      "clause"  => "=",
      "value"   => $companyId
    ];
    
    $request['condition'] = $condition;
    $request['limit']     = 10;

    $forms = Controller::retrieve($request, 'App\Http\Controllers\QueueFormController');
    return $this->manageForms($forms);
  }

  public function manageForms($forms){
    if($forms){
        if(sizeof($forms) > 1){
          //Show Forms
          $this->bot->reply($this->response->selectForms($forms),false);
        }
        else{
          //Direct Display
          $this->bot->reply($this->response->confirmation($forms[0]),false);
        }
    }
    else{
      $this->bot->reply($this->response->emptyForm(), false);
    }
  }

  public function retrieveFields(){
    $formId = $this->tracker->getFormId();
    $stage  = $this->tracker->getStage();
    if(!$formId && $stage == $this->code->stageForm){
      $this->bot->reply($this->response->ask('Name'), false);
    }
    else{
      $this->bot->reply($this->response->error(), false);
      $this->bot->reply($this->post->categories(), false);
    }

  }

  public function reply(){

  }

  public function validate(){

  }

  public function save(){

  }
  
}