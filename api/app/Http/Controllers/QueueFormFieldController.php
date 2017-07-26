<?php

namespace App\Http\Controllers;

use App\QueueFormField as DBItem;
use Illuminate\Http\Request;

class QueueFormFieldController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
  }
}
