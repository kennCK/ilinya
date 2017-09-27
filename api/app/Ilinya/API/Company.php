<?php

namespace App\Ilinya\API;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ilinya\API\Controller;

class Company{
    public static function retrieve($data, $column){
      $controller = 'App\Http\Controllers\CompanyController';
      $request = new Request();
       $condition[] = [
          "column"  => "id",
          "clause"  => "=",
          "value"   => $data['id']
        ];
      $request['condition'] = $condition;
      $results = Controller::retrieve($request, $controller);
      return (sizeof($results) > 0) ? $results[0][$column] : null;
    } 

}