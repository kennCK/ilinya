<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DepartmentMember;

class DepartmentMemberController extends APIController
{
  function __construct(){
    $this->model = new DepartmentMember();
  }
}
