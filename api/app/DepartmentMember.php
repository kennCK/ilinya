<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentMember extends APIModel
{
  protected $fillable = ['department_id', 'account_id', 'position'];
  protected $attributes = array(
    'position' => ''
  );
  public function  departments(){
    return $this->belongsTo('App\Department', 'id');
  }
  public function account_information(){
    return $this->belongsTo('App\AccountInformation', 'account_id');
  }
}
