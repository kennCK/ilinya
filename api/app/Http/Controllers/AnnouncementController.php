<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement as DBItem;

class AnnouncementController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
  }
}
