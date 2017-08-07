<?php

namespace App\Ilinya\Database;

use App\TempCustomFieldsStorage as DBFields;
use App\QueueFormField as FormFields;


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
}