<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends APIController
{
  function __construct(){
    $this->model = new Company();

    $this->validation = array(
      "accounts.email"  => "unique:accounts",
      "accounts.password" => "required"
    );

    $this->notRequired = array(
      "lat",
      "lng"
    );
  }

  public function create(Request $request){
     $request = $request->all();
     $request['username'] = $request['accounts.email'];
     $request['password'] = Hash::make($request['accounts.password']);
     //$this->createEntry($request);
     //return $this->output();
  }
}
