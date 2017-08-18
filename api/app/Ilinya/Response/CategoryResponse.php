<?php

namespace App\Ilinya\Response;

/*
    @Providers
*/
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


class CategoryResponse{

  protected $messaging;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
  }

  public function searchOption(){
      $quickReplies[] = QuickReplyElement::title('Company Name')->contentType('text')->payload('company_name@qrSearch');
      $quickReplies[] = QuickReplyElement::title('Company Location')->contentType('text')->payload('company_location@qrSearch');
      $quickReplies[] = QuickReplyElement::title('')->contentType('location')->payload('');

      return QuickReplyTemplate::toArray('Select options for search:', $quickReplies);
  }

  public function question($value){
    return ($value == "company_name")? "Enter Company Name:":"Enter Company Location:";
  }

  public function companies($data){
     $request = new Request();
     $condition[] = [
      "column"  => "business_type_id",
      "clause"  => "=",
      "value"   => $data['category']
    ];
     $request['condition'] = $condition;
     $request['sort'] = ["name" => "asc"];
     return $this->retrieve($request);
  }

  public function search($data){
    $request = new Request();
    $condition = [];

    switch ($$data['search_option']) {
      case 1:
        $condition[] = [
          "column"  => "name",
          "clause"  => "like",
          "value"   => "%".$data['value'].'%'
        ];
        break;
      case 2:
        $condition[] = [
          "column"  => "address",
          "clause"  => "like",
          "value"   => "%".$data['value'].'%'
        ];
        break;
      default:
        break;
    }

    $condition[] = [
      "column"  => "business_type_id",
      "clause"  => "=",
      "value"   => $data['category']
    ];
    
    $request['condition'] = $condition;
    $request['limit']     = 10;
    return $this->retrieve($request);
  }

  public function retrieve(Request $request){
    $data = Controller::retrieve($request, "App\Http\Controllers\CompanyController");
    return $this->manageResult($data);
  }

  public function manageResult($datas){
    $size = sizeof($datas);

    if($size < 9 && $datas){
      $elements = [];
      $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
      foreach ($datas as $data) {
        $buttons = [];
        $buttons[] = ButtonElement::title("Get Queue Cards Now!")
                    ->type('postback')
                    ->payload($data['id'].'@get_queue_cards')
                    ->toArray();
        $buttons[] = ButtonElement::title("Locate")
                    ->type('postback')
                    ->payload('@pLocate')
                    ->toArray();
        $elements[] = GenericElement::title($data['name'])
                            ->imageUrl($imgUrl)
                            ->subtitle('Address: '.$data['address'])
                            ->buttons($buttons)
                            ->toArray();

      }

      $buttons = [];
      $buttons[] = ButtonElement::title("Next")
          ->type('postback')
          ->payload('@pNext')
          ->toArray();
      $buttons[] = ButtonElement::title("Search")
          ->type('postback')
          ->payload('@pSearch')
          ->toArray();
      $buttons[] = ButtonElement::title("Back to Categories")
          ->type('postback')
          ->payload('@pCategories')
          ->toArray();
      $elements[] = GenericElement::title("There's more on this Category!")
                          ->imageUrl($imgUrl)
                          ->subtitle("Click Next or take a search:")
                          ->buttons($buttons)
                          ->toArray();

      $response =  GenericTemplate::toArray($elements);
      return $response;
    }
    else if($size > 10 && $datas){
      //
    }
    else{
      return ["text" => "Search not found :'("];
    }
  }


}

