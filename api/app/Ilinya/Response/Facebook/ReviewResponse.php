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

class ReviewResponse{
    private $user;
    private $messaging;
    private $curl;
    protected $tracker;
    protected $db_field = "temp_custom_fields_storage";


    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
        $this->tracker = new Tracker($messaging);
    }  

    /*
      Display all of the contents and text of Review   
    */
    public function user(){
        $user = $this->curl->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }

    public function display(){
        $this->user();
        $trackerId = $this->tracker->getId();
        $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
        $subtitle = "Get tickets or make reservations on category below:";
        $buttons = [];
        $elements = [];
        $fields = CustomFieldModel::getFieldsByTrackId($trackerId);
        $response = null;
        if($fields){
          if(sizeof($fields) < 10){
            foreach ($fields as $field) {
              $question = $this->getQuestion($field['field_id']);
              $buttons[] = ButtonElement::title("Edit")
                  ->type('postback')
                  ->payload('@pEdit')
                  ->toArray();
              $elements[] = GenericElement::title($question)
                                  ->subtitle($field['field_value'])
                                  ->buttons($buttons)
                                  ->toArray();
              $buttons = null;
            }
            $buttons[] = ButtonElement::title("Send")
                  ->type('postback')
                  ->payload('@pSend')
                  ->toArray();
            $buttons[] = ButtonElement::title("Disregard")
                  ->type('postback')
                  ->payload('@pDisregard')
                  ->toArray();
            $elements[] = GenericElement::title("Hi ".$this->user->getFirstName().'! You already reviewed your information.')
                                  ->subtitle("Kindly choose the options bellow:")
                                  ->buttons($buttons)
                                  ->toArray();
          }
          $response =  GenericTemplate::toArray($elements);
        }
        else{
          $response = ['text' => 'Error'];
        }
        return $response;
    }

    public function getQuestion($fieldId){
       $controller = 'App\Http\Controllers\QueueFormFieldController';
       $request = new Request();
       $condition[] = [
          "column"  => "id",
          "clause"  => "=",
          "value"   => $fieldId
        ];
       $request['condition'] = $condition;
       $data = Controller::retrieve($request, $controller);
       return ($data)?$data[0]['description']:null;
    }
    public function inform(){
        $this->user();

        return "Hi ".$this->user->getFirstName()."! Kindly review your information below:";
    }
}