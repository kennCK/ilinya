<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountProfilePicture extends APIModel
{
    use SoftDeletes;

    public function account(){
      return $this->belongsTo('App\Acccount', 'id');
    }
}
