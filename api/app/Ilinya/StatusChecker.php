<?php

namespace App\Ilinya;

use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Database\DBManager as DB;

class StatusChecker{
  
  protected $status;
  protected $category;


  protected $db_tracker = "bot_status_tracker";

  protected $messaging;

  function __construct(Messaging $messaging){
    $this->messaging = $messaging;
    $this->retrieve();
  }

  public function insert($status){
      $data = [
        "facebook_id" => $this->messaging->getSenderId(),
        "status"      => $status
      ];
      DB::insert($this->db_tracker, $data);
  }

  public function update($status, $data){
        $condition = [
            ['facebook_id','=',$this->messaging->getSenderId()]
        ];
        $data      = ["status" => $status];
        $result = DB::retrieve($this->db_tracker, $condition); 
        if(!$result)
          $this->insert($status);
        else{
          DB::update($this->db_tracker, $condition, $data);
        }
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

  public function getStatus(){
    echo $this->status;
    return $this->status;
  }

  public function getCategory(){
    return $this->category;
  }

}