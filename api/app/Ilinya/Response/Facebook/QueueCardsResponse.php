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


class QueueCardsResponse{
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

    /*
      Display all of the contents and text of Review   
    */
    public function user(){
        $user = $this->curl->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }

    public function display(){
      /*
        1. Get User Id via Facebok Id
        2. Get Queue Cards
        3. Display
      */
      $controller = 'App\Http\Controllers\FacebookUserController';
      $request = new Request();

      $condition [] = [
        'column'  => 'account_number',
        'clause'  => '=',
        'value'   => $this->messaging->getSenderId()
      ];

      $request['condition'] = $condition;
      $userField = Controller::retrieve($request, $controller);

      if($userField){
        /*
          1. Loop Queue Cards Heres
        */
          return $this->getQueueCardByUserId($userField[0]['id']);
      }
      else{
          return ['text' => "User ID:".$this->messaging->getSenderId().' is not on the Database.'];
      }
    }

    public function getQueueCardByUserId($userId){
      $controller = 'App\Http\Controllers\QueueCardController';
      $request = new Request();

      $condition [] = [
        'column'  => 'facebook_user_id',
        'clause'  => '=',
        'value'   => $userId
      ];

      $request['condition'] = $condition;
      $request['sort'] = ['created_at' => 'asc'];
      $qc = Controller::retrieve($request, $controller);

      if($qc){
        /*
          1. Display Cards
          2. Use Generic Templates
        */
        return ['text' => 'Your Card:'.$qc[0]['id'].','.$qc[1]['id']];
      }
      else{
        return ['text' => 'No Cards Found!'];
      }
    }


}