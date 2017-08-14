<?php

namespace App\Ilinya\Response;

/*
    @Providers
*/
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\User;

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


class Search{

  protected $messaging;
  protected $curl;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->curl = new Curl();
  }

  public function options(){
      $quickReplies[] = QuickReplyElement::title('Company Name')->contentType('text')->payload('company_name@search');
      $quickReplies[] = QuickReplyElement::title('Company Location')->contentType('text')->payload('company_location@search');
      $quickReplies[] = QuickReplyElement::title('')->contentType('location')->payload('');

      return QuickReplyTemplate::toArray('Select options for search:', $quickReplies);
  }

  public function question($value){
    return ($value == "company_name")? "Enter Company Name:":"Enter Company Location:";
  }

}

