<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ai extends APIModel
{ 
    protected $table = "ai";
    protected $fillable = ['question', 'answer', 'action'];  
}
