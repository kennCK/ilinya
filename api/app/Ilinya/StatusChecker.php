<?php

namespace App\Ilinya;

use App\Ilinya\Message\Codes;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Database\DBManager as DB;

class StatusChecker{
  
  protected $status;
  protected $category;


  protected $db_tracker = "bot_status_tracker";

  protected $messaging;

  protected $code;

  function __construct(Messaging $messaging){
    $this->messaging = $messaging;
    $this->code = new Codes();
    $this->retrieve();
  }

  public function getStatus($custom){
    $prev = $this->status;
    $current = $this->code->getCodeByUnknown($custom);
    

    if(!$prev){
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
      echo $current;
      return 3000;
    }
    else{
      return 0;
    }

  }

  public function insert($status){
      $data = [
        "facebook_id" => $this->messaging->getSenderId(),
        "status"      => $status
      ];
      DB::insert($this->db_tracker, $data);
  }

  public function update($status){
        $condition = [
            ['facebook_id','=',$this->messaging->getSenderId()]
        ];
        $data      = ["status" => $status];
        DB::update($this->db_tracker, $condition, $data);
  }

  public function retrieve(){
      $condition = [
          ['facebook_id','=',$this->messaging->getSenderId()]
      ];
      $result = DB::retrieve($this->db_tracker, $condition);

      if($result){
          foreach ($result as $key) {
              $this->status = $key['status'];
              $this->category = $key['category'];
          }
      }
  }

  public function delete(){
    $condition = [
          ['facebook_id','=',$this->messaging->getSenderId()]
    ];

    DB::delete($this->db_tracker, $condition);
  }

}