<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ai;
class AiController extends APIController
{
    function __construct(){
      $this->model = new Ai();

      $this->notRequired = array(
        "answer",
        "action",
        "action_type"
      );
    }
}
