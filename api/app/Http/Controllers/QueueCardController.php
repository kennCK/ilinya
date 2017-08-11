<?php

namespace App\Http\Controllers;
use App\QueueCard as DBItem;
use Illuminate\Http\Request;

class QueueCardController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->editableForeignTable = array(
      'queue_card_fields'
    );
    $this->notRequired = array(
      'user_id',
      'status'
    );
    $this->foreignTable = array(
      'facebook_user'
    );
    $this->editableForeignTable = array(
      'queue_card_fields'
    );
    $this->defaultValue = array(
      'company_id' => $this->getUserCompanyID(),
      'status' => 1,
      'user_id' => 0
    );
  }
  public function update(Request $request){
    $reqArray = $request->toArray();
    if(isset($reqArray['status'])){
      $this->response['debug'][] = $reqArray['status'];
      switch($reqArray['status'] * 1){
        case 2:
          $reqArray['datetime_served'] = date('Y-m-d H:i:s', time());
          break;
        case 3:
          $reqArray['datetime_finished'] = date('Y-m-d H:i:s', time());
          break;
      }
    }
    $this->updateEntry($reqArray);
    return $this->output();
  }
}
