<?php
namespace App\Ilinya\Conversation;

use App\Ilinya\Database\CustomFields as Fields;

class Conversation{
  
  protected $id;
  protected $fieldName;
  protected $fieldValue;

  public static function run(){

    Fields::save($this->id,$this->fieldName,$this->fieldValue);
  }
}