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
use App\Ilinya\Response\Facebook\DisregardResponse;
use App\Ilinya\Response\Facebook\ErrorResponse;
use App\Ilinya\Webhook\Facebook\Messaging;

class Error{
    protected $code;
    protected $tracker;
    protected $error;
    protected $bot;
    protected $forms;

    function __construct(Messaging $messaging){
        $this->bot    = new Bot($messaging);
        $this->forms   = new Form($messaging);
        $this->tracker= new Tracker($messaging);
        $this->code   = new Codes(); 
        $this->error  = new ErrorResponse($messaging);
    }

    public function manage($custom){
      
    }
}