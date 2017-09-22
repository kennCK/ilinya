<?php
namespace App\Ilinya\Response\Facebook;

/*
    @Providers
*/
use App\Ilinya\Webhook\Facebook\Messaging;
use App\Ilinya\User;
use App\Ilinya\Tracker;
use Illuminate\Http\Request;
use App\Ilinya\Response\Facebook\CategoryResponse;
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


class SearchResponse{

  protected $messaging;
  protected $tracker;
  protected $category;

  public function __construct(Messaging $messaging){
      $this->messaging = $messaging;
      $this->tracker   = new Tracker($messaging);
      $this->category  = new CategoryResponse($messaging);
  }

  public function manage($value){
      return $this->category->search($value, null);
  }

  public function searchOption(){
      $quickReplies[] = QuickReplyElement::title('Company Name')->contentType('text')->payload('1@qrSearch');
      $quickReplies[] = QuickReplyElement::title('Company Location')->contentType('text')->payload('2@qrSearch');
      $quickReplies[] = QuickReplyElement::title('')->contentType('location')->payload('');

      return QuickReplyTemplate::toArray('Select options for search:', $quickReplies);
  }

  public function question($option){
    return ($option == '1' || intval($option) == 1)? "Enter Company Name:":"Enter Company Location:";
  }
}