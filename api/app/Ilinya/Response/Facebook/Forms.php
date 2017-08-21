<?php

namespace App\Ilinya\Response\Facebook;
/*
    @Providers
*/
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\User;
use App\Ilinya\StatusChecker;
use Illuminate\Http\Request;
/*
    @Template
*/
use App\Ilinya\Templates\Facebook\QuickReplyTemplate;
use App\Ilinya\Templates\Facebook\ButtonTemplate;
use App\Ilinya\Templates\Facebook\GenericTemplate;
use App\Ilinya\Templates\Facebook\LocationTemplate;
use App\Ilinya\Templates\Facebook\ListTemplate;

/*
    @Elements
*/

use App\Ilinya\Templates\Facebook\ButtonElement;
use App\Ilinya\Templates\Facebook\GenericElement;
use App\Ilinya\Templates\Facebook\QuickReplyElement;


/*
    @API
*/
use App\Ilinya\API\Controller;

class Forms{
  protected $messaging;
  protected $checker;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->checker   = new StatusChecker($messaging);
  }

  public function retrieve(){
    $request = new Request();
    $condition[] = [
      "column"  => "company_id",
      "clause"  => "=",
      "value"   => $this->checker->getCompanyId()
    ];
    
    $request['condition'] = $condition;
    $request['limit']     = 10;

    $forms = Controller::call($request, 'App\Http\Controllers\QueueFormController');
    return $this->manageForms($forms);
  }

  public function manageForms($forms){
    if($forms){
        if(sizeof($forms) > 1){
          //Show Forms
          return $this->selectForms();
        }
        else{
          //Direct Display
          return $this->ask($forms);
        }
    }
    else{
      return ['text'  => 'No Forms Available'];
    }
  }

  public function selectForms(){
      return ['text'  => "Select form:"];
  }

  public function ask($forms){
      return ['text'  => "Enter Something"];
  }
}