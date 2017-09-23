<?php
namespace App\Ilinya\Response\Facebook;

/*
    @Providers
*/
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\User;
use Illuminate\Http\Request;
use App\Ilinya\Tracker;
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
  protected $tracker;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->tracker   = new Tracker($messaging);
  }

  public function companies($businessTypeId){
     $request = new Request();
     $condition[] = [
      "column"  => "business_type_id",
      "clause"  => "=",
      "value"   => $businessTypeId
    ];
     $request['condition'] = $condition;
     $request['sort'] = ["name" => "asc"];
     return $this->retrieve($request);
  }

  public function search($value, $category = null){
    $request = new Request();
    $condition = [];

    switch ($this->tracker->getSearchOption()) {
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

    if($category){
        $condition[] = [
          "column"  => "business_type_id",
          "clause"  => "=",
          "value"   => $category
        ];
    }
   
    
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
    $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
    if($size < 9 && $datas){
      $elements = [];
      
      foreach ($datas as $data) {
        $buttons = [];
        if($data['id'] != '6' || intval($data['id']) != 6){
          $availability = $this->availability($data['id']);
          $buttons[] = ($availability == true)?ButtonElement::title("Get QCard")
                      ->type('postback')
                      ->payload($data['id'].'@pGetQueueCard')
                      ->toArray():ButtonElement::title("View Location")
                      ->type('web_url')
                      ->url('https://www.instantstreetview.com/@'.$data['lat'].','.$data['lng'].',11z,1t')
                      ->ratio('full')
                      ->toArray();
          $buttons[] = ($availability == true)?ButtonElement::title("View Location")
                      ->type('web_url')
                      ->url('https://www.instantstreetview.com/@'.$data['lat'].','.$data['lng'].',11z,1t')
                      ->ratio('full')
                      ->toArray():ButtonElement::title("Back to Categories")
                      ->type('postback')
                      ->payload('@pCategories')
                      ->toArray();
         
          $availabilityText = ($availability == true)? ' is Available':' is not Available';
          $availabilityText .= ' for Transaction!';
          $elements[] = GenericElement::title($data['name'].$availabilityText)
                              ->imageUrl($imgUrl)
                              ->subtitle('Address: '.$data['address'])
                              ->buttons($buttons)
                              ->toArray();
        }
      }
      $response =  GenericTemplate::toArray($elements);
      return $response;
    }
    else if($size > 10 && $datas){
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
    else{
      return ["text" => "Search not found :'("];
    }
  }
  
  public function availability($companyId){
    $response     = true;
    $controller   = "App\Http\Controllers\QueueFormController";
    $request      = new Request();

    $condition[] = [
          "column"  => "company_id",
          "clause"  => "=",
          "value"   => $companyId
       ];

    $request['condition'] = $condition;

    $result = Controller::retrieve($request, $controller);
    if(sizeof($result) > 0){
      $flag = true;
      foreach ($result as $row) {
        if(intval($row['availability']) >= 2){
          $flag = false;
          break;
        }
      }
      if ($flag == false) {
        $response = false;
      }
      else{
        $response = true;
      }
    }
    else{
       $response = true;
    }
    return $response;
  }


}

