<?php

namespace App\Ilinya\Response;

/*
    @Providers
*/
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\User;
use App\Ilinya\StatusChecker;
use Illuminate\Http\Request;
/*
    @Template
*/
use App\Ilinya\Templates\Facebook\QuickReplyTemplate;
use App\Ilinya\Templates\Facebook\ButtonTemplate;
use App\Ilinya\Templates\Facebook\GenericTemplate;
use App\Ilinya\Templates\Facebook\LocationTemplate;
use App\Ilinya\Templates\Facebook\ListTemplate;

/*
    @Elements
*/

use App\Ilinya\Templates\Facebook\ButtonElement;
use App\Ilinya\Templates\Facebook\GenericElement;
use App\Ilinya\Templates\Facebook\QuickReplyElement;


/*
    @API
*/
use App\Ilinya\API\Controller;


class Search{

  protected $messaging;
  protected $curl;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->curl = new Curl();
  }

  public function options(){
      $quickReplies[] = QuickReplyElement::title('Company Name')->contentType('text')->payload('company_name@search');
      $quickReplies[] = QuickReplyElement::title('Company Location')->contentType('text')->payload('company_location@search');
      $quickReplies[] = QuickReplyElement::title('')->contentType('location')->payload('');

      return QuickReplyTemplate::toArray('Select options for search:', $quickReplies);
  }

  public function question($value){
    return ($value == "company_name")? "Enter Company Name:":"Enter Company Location:";
  }


  public function handler($value, StatusChecker $checker){
    $status = $checker->getPrevStatus();
    $searchOption = $checker->getSearchOption();
    $category = $checker->getCategory();
    $request = new Request();
    $condition = [];

    switch ($searchOption) {
      case 1:
        $condition[] = [
          "column"  => "name",
          "clause"  => "like",
          "value"   => "%".$value.'%'
        ];
        break;
      case 2:
        $condition[] = [
          "column"  => "address",
          "clause"  => "like",
          "value"   => "%".$value.'%'
        ];
        break;
      default:
        break;
    }

    $condition[] = [
      "column"  => "business_type_id",
      "clause"  => "=",
      "value"   => $category
    ];
    
    $request['condition'] = $condition;
    $request['limit']     = 10;
    $data = Controller::call($request, "App\Http\Controllers\CompanyController");
    return $this->manageResult($data);
  }

  public function manageResult($datas){
    if($datas){
      $elements = [];
      foreach ($datas as $data) {
        $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
        $buttons = [];
        $buttons[] = ButtonElement::title("Get Queue Cards Now!")
                    ->type('postback')
                    ->payload($data['id'].'@get_queue_cards')
                    ->toArray();
        $buttons[] = ButtonElement::title("Close")
                    ->type('postback')
                    ->payload('@shutdown')
                    ->toArray();
        $elements[] = GenericElement::title($data['name'])
                            ->imageUrl($imgUrl)
                            ->subtitle('Address: '.$data['address'])
                            ->buttons($buttons)
                            ->toArray();
      }
      $response =  GenericTemplate::toArray($elements);
      return $response;
    }
    else{
      return ["text" => "Search not found :'("];
    }
  }


}

