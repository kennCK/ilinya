<?php

namespace App\Ilinya;

use App\Ilinya\Message\Codes;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\API\Database as DB;

class StatusChecker{
  
  protected $status;
  
  protected $reply;

  protected $category;

  protected $searchOption;

  protected $companyId;

  protected $stage;

  protected $db_tracker = "bot_status_tracker";

  protected $messaging;

  protected $code;


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
    $current = $this->code->getCodeByUnknown($custom);
  
    if(!$prev){
      //@start if user not exist
      return 2000;
    }
    else if($current == $this->code->READ){
      return 0;
    }
    else if($current == $this->code->DELIVERY){
      return 1000;
    }
    else if($current <= $this->code->P_LIMIT && $current >= $this->code->POSTBACK){
      return 2001;
    }
    else if($current >= $this->code->MESSAGE){
      return 3000;
    }
    else{
      return 0;
    }

  }

  public function insert($status, $stage, $category = null){
      $data = [
        "facebook_id" => $this->messaging->getSenderId(),
        "status"      => $status,
        "stage"       => $stage
      ];
      if($category)$data['category'] = $category;
      DB::insert($this->db_tracker, $data);
  }

  public function update($data){
        $condition = [
            ['facebook_id','=',$this->messaging->getSenderId()]
        ];
        DB::update($this->db_tracker, $condition, $data);
  }

  public function retrieve(){
    $pageID = "133610677239344";

    if($this->messaging->getSenderId() != $pageID){
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
      $this->status = 1000;
    }
  }

  public function delete(){
    $condition = [
          ['facebook_id','=',$this->messaging->getSenderId()]
    ];

    DB::delete($this->db_tracker, $condition);
  }

}