<?php

namespace App\Ilinya\API;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ilinya\API\Controller;

class QueueCardFields{

  public static function retrieve($data){
     $controller = 'App\Http\Controllers\QueueCardFieldController';
     $request = new Request();
     $condition[] = [
          "column"  => $data['column'],
          "clause"  => "=",
          "value"   => $data['value']
     ];
     $request['condition'] = $condition;
     return Controller::retrieve($request, $controller);
  }

  public function update($data, $condition){
     $controller = 'App\Http\Controllers\QueueCardFieldController';
     $request = new Request();
     $request['queue_card_id']         = $data['queue_card_id'];
     $request['queue_form_field_id']   = $data['queue_form_field_id'];
     $request['value']                 = $data['value'];
    return Controller::update($request, $controller);
  }

  public static function create($data){
     $controller = 'App\Http\Controllers\QueueCardFieldController';
     $request = new Request();
     $request['queue_card_id']         = $data['queue_card_id'];
     $request['queue_form_field_id']   = $data['queue_form_field_id'];
     $request['value']                 = $data['value'];
     return Controller::create($request, $controller);
  }

}