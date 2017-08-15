<?php

namespace App\Ilinya\API;

use Illuminate\Http\Request;

//use App\Http\Controllers\BusinessTypeController;

class Controller{
  public static function call(Request $request, $controller){
    $result = app($controller)->retrieve($request);
    $result = json_decode($result->getContent(), true);
    $data   = $result['data'];
    return $data;
  }
}
