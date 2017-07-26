<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product as Item;

class OrderController extends APIController
{

    function __construct(){
      $this->model = new Item();
      $this->validation = array(
      );
      $this->notRequired = array('image', 'rice', 'barley', 'basmati_rice');
      $this->defaultValue = array(
        'rice' => 0, 'barley' => 0, 'basmati_rice' => 0
      );
    }
}
