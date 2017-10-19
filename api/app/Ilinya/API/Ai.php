<?php

namespace App\Ilinya\API;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ilinya\API\Controller;

class Ai{
    public static function retrieve($data){
      $controller = 'App\Http\Controllers\AiController';
      $request = new Request();
       $condition[] = [
          "column"  => $data['column'],
          "clause"  => $data['clause'],
          "value"   => ($data['clause'] == '=') ? $data['value'] : "%".$data['value']."%"
        ];
      $request['condition'] = $condition;
      $request['limit'] = 1;
      return Controller::retrieve($request, $controller);
    } 

    public static function create($data){
      $controller = 'App\Http\Controllers\AiController';

      $request = new Request($data);
      return Controller::create($request, $controller);
    }

}
