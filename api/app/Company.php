<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends APIModel
{
  public function business_type(){
    return $this->belongsTo('App\BusinessType', 'id');
  }

  public function company_logo(){
    return $this->hasOne('App\CompanyLogo');
  }

  public function company_branches(){
    return $this->hasMany('App\CompanyBranch');
  }
}