<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AccountController extends APIController
{
     function __construct(){  
        $this->model = new Account();
        $this->validation = array(  
          "email" => "unique:accounts",
          "username"  => "unique:accounts",
          "account_information.first_name" => "required",
          "account_information.last_name" => "required" ,
          "company_branch_employees.identification_number" => "required",
          "company_branch_employees.company_branch_id" => "required"
        );
        $this->editableForeignTable = array(
          'account_information',
          'company_branch_employees',
        );
        $this->foreignTable = array(
          'account_information',
          'company_branch_employees'
        );
    } 

    public function create(Request $request){
     $request = $request->all();
     $request['username'] = $request['email'];
     $request['password'] = Hash::make($request['email']);
     $this->createEntry($request);
     return $this->output();
    }

    public function update(Request $request){ 
      $this->updateEntry($this->hashPassword($request));
      return $this->output();
    }

    public function hashPassword(Request $request){
      $data = $request->all();
      $data['password'] = Hash::make($data['password']);
      return $data;
    }
}
