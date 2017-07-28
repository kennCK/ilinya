<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends APIModel
{
    public function company_branches(){
      return $this->belongsTo('App\CompanyBranch', 'id');
    }
    public function department_head(){
      return $this->hasOne('App\DepartmentMember')->where('is_head', 1)->with('account_information');
    }
    public function department_members(){
      return $this->hasMany('App\DepartmentMember')->with('account_information');
    }
}
