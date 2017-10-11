<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends APIModel
{
    protected $hidden = array('password');
    protected $fillable = ['email', 'username', 'password','company_id'];

    public function account_information(){
      return $this->hasOne('App\AccountInformation');
    }

    public function account_profile_pictures(){
      return $this->hasOne('App\AccountProfilePicture');
    }

    public function account_positions(){
      return $this->hasOne('App\AccountPosition');
    }
    
    public function company(){
      return $this->hasMany('App\Company');
    }
}