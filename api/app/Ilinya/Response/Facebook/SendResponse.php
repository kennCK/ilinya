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
use App\Ilinya\API\Controller;
use App\Ilinya\API\CustomFieldModel;
use App\Ilinya\ImageGenerator;
use App\Ilinya\API\Facebook;


class SendResponse{
    private $user;
    private $messaging;
    private $curl;
    protected $tracker;
    protected $db_field = "temp_custom_fields_storage";
    protected $userId;
    protected $cardId;


    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
        $this->tracker = new Tracker($messaging);
    }  

    public function user(){
        $user = $this->curl->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }

    /*
      1. Get the Field
      2. Check get new QC
      3. Transfer the Fields
      4. Set the tracker to Null
    */

    public function submit(){
      $response = null;
      $trackerId = $this->tracker->getId();
      $fields = CustomFieldModel::getFieldsByTrackId($trackerId);
      if($fields){
        $this->manageUser();
        $this->createQueueCard();
        foreach ($fields as $field) {
          $cRequest = new Request();
          $cRequest['queue_card_id'] = $this->cardId;
          $cRequest['queue_form_field_id'] = $field['field_id'];
          $cRequest['value'] = $field['field_value'];
          $this->createQueueCardFields($cRequest);
        }
         if($this->tracker->getCompanyId() != 6){
          $response = $this->queueCard();
         }
        
         $this->tracker->delete();
        //ImageGenerator::create($this->cardId);
      }
      else{
        $response = ['text' => "Empty Fields"];
      }
      return $response;
    }

    public function queueCard(){
        $this->user();
        $title =  "Hi ".$this->user->getFirstName()." :) Here's your Queue Card #:".$this->cardId;
        $subtitle = "Status: On Queue";
        $imageUrl = "http://ilinya.com/wp-content/uploads/2017/08/cropped-logo-copy-copy.png";
        $buttons[] = ButtonElement::title("Cancel")
                    ->type('postback')
                    ->payload($this->cardId.'@pCancelQueueCard')
                    ->toArray();
        $buttons[] = ButtonElement::title("Postpone")
                    ->type('postback')
                    ->payload($this->cardId.'@pPostponeQueueCard')
                    ->toArray();
        $elements[] = GenericElement::title($title)
                            ->imageUrl($imageUrl)
                            ->subtitle($subtitle)
                            ->buttons($buttons)
                            ->toArray();
        $response =  GenericTemplate::toArray($elements);
        return $response;
    }


    public function manageUser(){
      $fbController = 'App\Http\Controllers\FacebookUserController';
      $request = new Request();
      $this->user();
      $senderId = $this->messaging->getSenderId();
      $completeName = $this->user->getFirstName().' '.$this->user->getLastName();

       $condition[] = [
          "column"  => "account_number",
          "clause"  => "=",
          "value"   => $senderId
       ];

       $request['condition'] = $condition;
       $user = Controller::retrieve($request, $fbController);
       if($user){
          $this->userId = $user[0]['id'];
       }
       else{
          $newRequest = new Request();

          $newRequest['account_number'] = $senderId;
          $newRequest['full_name']   = $completeName;
          $result = Controller::create($newRequest, $fbController);
          if($result != false)
            $this->userId = $result;
          else
            $this->userId = null;
       }
    }
    public function createQueueCard(){
      /*
        1. Get Fields
        2. Tracker
        3. Get New Card Number
           - Get Previous  + 1
      */
        $controller = 'App\Http\Controllers\QueueCardController';
        //@tracker
        $companyId = $this->tracker->getCompanyId();
        $queueFormId = $this->tracker->getFormId();
        $reCon = new Request();
        $condition[] = [
          "column"  => "company_id",
          "clause"  => "=",
          "value"   => $companyId
        ];
        $condition[] = [
          "column"  => "queue_form_id",
          "clause"  => "=",
          "value"   => $queueFormId
        ];
        $condition[] = [
          "column"  => "facebook_user_id",
          "clause"  => "=",
          "value"   => Facebook::getDynamicField($this->messaging->getSenderId(), 'id')
        ];

        $reCon['condition'] = $condition;

        $result = Controller::retrieve($reCon, $controller);

        if(!$result){
          $request = new Request();
          $request['company_id'] = $companyId;
          $request['queue_form_id'] = $queueFormId;
          $request['facebook_user_id'] = $this->userId;
          $request['number']  = 0;
          echo json_encode($request->all());
          $result = Controller::create($request, $controller);
          $this->cardId = ($result != false)? $result:null;  
        }
        else{
          $this->cardId = $result[0]['id'];
        }
    }

    public function createQueueCardFields(Request $request){
       $controller = 'App\Http\Controllers\QueueCardFieldController';
      /*
        1. Get Queue Card ID - Given
        2. Get Queue Form Field ID - Given
      */
        $result = Controller::insert($request, $controller);

        return ($result != null)? true:false;
    }

}