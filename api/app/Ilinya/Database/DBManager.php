<?php

namespace App\Ilinya\Database;

use App\TempCustomFieldsStorage as DBFields;
use App\QueueFormField as FormFields;
use App\BotStatusTracker;

class DBManager{
  public static function get($queueFormId){
    return FormFields::where('queue_form_id', $queueFormId)->orderBy('sequence')->get();
  }

  public static function save($facebookId, $fieldName, $fieldValue){
    $data = array(
      "facebook_id"   => $facebookId,
      "field_name"   => $fieldName,
      "field_value"   => $fieldValue
    );

    return DBFields::save($data);
  }

  public static function saveStatus($userId, $status){
    $tracker = new BotStatusTracker();
    $tracker->facebook_id = $userId;
    $tracker->status = $status;
    $tracker->save();
  }

  public static function updateStatus($userId, $status){
    $data = array("status" => $status);
    $tracker = BotStatusTracker::where('facebook_id', $userId)->update($data);
  }
}