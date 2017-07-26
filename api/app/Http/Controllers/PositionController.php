<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;

class PositionController extends APIController
{
  function __construct(){
    $this->model = new Position();
  }
}
