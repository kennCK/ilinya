<?php
namespace App\Ilinya\Response\Facebook;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\User;
use App\Ilinya\Tracker;
use App\Ilinya\API\Database as DB;
use App\Ilinya\Templates\Facebook\QuickReplyTemplate;
use App\Ilinya\Templates\Facebook\ButtonTemplate;
use App\Ilinya\Templates\Facebook\GenericTemplate;
use App\Ilinya\Templates\Facebook\LocationTemplate;
use App\Ilinya\Templates\Facebook\ListTemplate;
use App\Ilinya\Templates\Facebook\ButtonElement;
use App\Ilinya\Templates\Facebook\GenericElement;
use App\Ilinya\Templates\Facebook\QuickReplyElement;
use App\Ilinya\Response\Facebook\ReviewResponse;
use App\Ilinya\API\Controller;
use App\Ilinya\API\CustomFieldModel;
use Illuminate\Support\Facades\Validator;


class ErrorResponse{
    private $user;
    private $messaging;
    private $curl;
    protected $tracker;
    protected $db_field = "temp_custom_fields_storage";
    protected $review;


    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
        $this->tracker = new Tracker($messaging);
        $this->review  = new ReviewResponse($messaging);
    }

     public function user(){
        $user = $this->curl->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }

    public function stage(){
    $this->user();
      $companyData = $this->tracker->getCompanyData();
      $title = "Hi ".$this->user->getFirstName().'! You are about to get/make '.$form['title'].' to '.$companyData[0]['name'].'. Are you sure you want to continue?';
      $quickReplies[] = QuickReplyElement::title('No')->contentType('text')->payload($form['id'].'@qrFormCancel');
      $quickReplies[] = QuickReplyElement::title('Yes')->contentType('text')->payload($form['id'].'@qrFormContinue');
      return QuickReplyTemplate::toArray($title, $quickReplies);
    }

}