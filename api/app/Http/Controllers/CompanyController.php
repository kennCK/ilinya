<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    $this->editableForeignTable = array(
      'accounts'
    );
    $this->foreignTable = array(
      'accounts'
    );
  }

  public function create(Request $request){
     $request = $request->all();
     $request['accounts']['username'] = $request['accounts']['email'];
     $request['accounts']['password'] = Hash::make($request['accounts']['password']);
     echo json_encode($request);
     $this->createEntry($request);
     return $this->output();
  }
}
