<?php

namespace App\Ilinya\Conversation;


class SearchCompany{

  public static function search($searchType){
    return ($searchType == "@company_name")? "Enter Company Name:": "Enter Company Location:";
  }

  public static function searchByNearyByLocation($lat, $long){
  }

}