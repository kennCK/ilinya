<?php

namespace App\Ilinya;

use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\API\Database as DB;

class Tracker{
  
  protected $status;
  
  protected $reply;

  protected $category;

  protected $searchOption;

  protected $companyId;

  protected $stage;

  protected $db_tracker = "bot_status_tracker";

  protected $messaging;

  protected $code;

  protected $pageID = "133610677239344";


  function __construct(Messaging $messaging){
    $this->messaging = $messaging;
    $this->code = new Codes();
    $this->retrieve();
  }

  public function getReply(){
    return $this->reply;
  }

  public function getSearchOption(){
    return $this->searchOption;
  }

  public function getPrevStatus(){
    return $this->status;
  }

  public function getCategory(){
    return $this->category;
  }

  public function getCompanyId(){
    return $this->companyId;
  }

  public function getStage(){
    return $this->stage;
  }

  public function getStatus($custom){
    $prev = $this->status;
    $current = $this->code->getCode($custom);
    $response = array();

    if($current == $this->code->read){
      $response = [
        "status"  => $this->code->read,
        "stage"   => null
      ];
    }
    else if($current == $this->code->delivery){
      $response = [
        "status"  => $this->code->delivery,
        "stage"   => null
      ];
    }
    else if(!$prev){
      $response = [
        "status"  => $this->code->pStart,
        "stage"   => $this->code->pStart
      ];
    }
    else if($current < $this->code->message && $current >= $this->code->postback){
      $response = [
        "status"  => $this->code->postback,
        "stage"   => null
      ];
    }
    else if($current < $this->code->error && $current >= $this->code->message){
      $response = [
        "status"  => $this->code->message,
        "stage"   => null
      ];
    }
    else{
      $response = [
        "status"  => $this->code->error,
        "stage"   => null
      ];
    }
    return $response;
  }

  public function insert($status, $stage, $category = null){
       if($this->messaging->getSenderId() != $this->pageID){
        $data = [
          "facebook_id" => $this->messaging->getSenderId(),
          "status"      => $status,
          "stage"       => $stage
        ];
        if($category)$data['category'] = $category;
        DB::insert($this->db_tracker, $data);
    }
  }

  public function update($data){
        $condition = [
            ['facebook_id','=',$this->messaging->getSenderId()]
        ];
        DB::update($this->db_tracker, $condition, $data);
  }

  public function retrieve(){
    $pageID = "133610677239344";

    if($this->messaging->getSenderId() != $this->pageID){
      $condition = [
          ['facebook_id','=',$this->messaging->getSenderId()]
      ];
      $result = DB::retrieve($this->db_tracker, $condition);

      if($result){
          foreach ($result as $key) {
              $this->status       = $key['status'];
              $this->stage        = $key['stage'];            
              $this->companyId    = $key['company_id'];
              $this->category     = $key['business_type_id'];
              $this->searchOption = $key['search_option'];
              $this->reply        = $key['reply'];  
          }
      }
    }
    else{
      $this->status = null;
    }
  }

  public function delete(){
    $condition = [
          ['facebook_id','=',$this->messaging->getSenderId()]
    ];

    DB::delete($this->db_tracker, $condition);
  }

}