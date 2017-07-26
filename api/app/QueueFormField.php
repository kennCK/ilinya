<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueFormField extends APIModel
{
    protected $fillable = ['description'];
    protected $attributes = array(
      'type' => 'text'
    );

}
