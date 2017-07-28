<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentController extends APIController
{

  function __construct(){
    $this->model = new Department();

    $this->validation = array(
      "email" => "unique:departments"
    );
    $this->notRequired = array(
      "fax_number",
      "logo"
    );
    $this->editableForeignTable = array(
      'department_members'
    );
    $this->foreignTable = array(
      'department_head'
    );
    $this->singleImageFileUpload = array(
      array(
        "name" => 'logo_file',
        "path" => 'images/department',
        "column" => 'logo',
        "replace" => true
      )
    );
  }
}
