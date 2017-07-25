<?php

namespace App\Http\Controllers;

use App\CompanyBranch;
use Illuminate\Http\Request;

class CompanyBranchController extends APIController
{
    function __construct(){
        $this->model = new CompanyBranch();
        $this->validation = array(  
          "email" => "unique:company_branches"
        );
    }
}
