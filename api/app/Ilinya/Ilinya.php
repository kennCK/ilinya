<?php


namespace App\Ilinya;

use Illuminate\Support\Facades\Cache;

/*
    @Providers
*/
use App\Ilinya\Http\Curl;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\User;

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
    @Message
*/

use App\Ilinya\Message\Attachments;


/*
    @Models
*/
use App\BusinessType;

class Ilinya{
  
    public  $GET_STARTED      = "@start";
    public  $CATEGORIES       = "@categories";
    public  $MY_QUEUE_CARDS   = "@my_queue_cards";
    public  $USER_GUIDE       = "@users_guide";
    public  $CONVERSATION     = "@conversation";
    public $ERROR             = "I'm sorry but I can't do what you want me to do :'(";
    private $user;
    private $messaging;
    private $curl;

    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->curl = new Curl();
        
    }   

    public function user(){
        $user = $this->curl->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }

    public function start(){
        $this->user();
        return "Hi ".$this->user->getFirstName()."! My Name is Ilinya, I can help to get your reservations or tickets easily. Just follow my instructions and you will be good to go!";
    }
    
    public function categories(){
        $categories = BusinessType::orderBy('category')->get();
        $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
        $subtitle = "Get tickets or make reservations on category below:";
        $buttons = [];
        $elements = [];

        if($categories){
            $prev = $categories[0]['category'];
            $i = 0;
            foreach ($categories as $category) {
                $buttons[] = ButtonElement::title($category['sub_category'])
                    ->type('postback')
                    ->payload('categories@'.strtolower($category['sub_category']))
                    ->toArray();
                if($i < sizeof($categories) - 1){
                    if($prev != $categories[$i + 1]['category']){
                        $title = $category['category'];
                        $elements[] = GenericElement::title($title)
                            ->imageUrl($imgUrl)
                            ->subtitle($subtitle)
                            ->buttons($buttons)
                            ->toArray();
                        $prev = $category['category'];
                        $buttons = null;
                    }
                }
                else{
                    $title = $category['category'];
                    $elements[] = GenericElement::title($title)
                        ->imageUrl($imgUrl)
                        ->subtitle($subtitle)
                        ->buttons($buttons)
                        ->toArray();
                }
                
                $i++;
            }
        }

        $response =  GenericTemplate::toArray($elements);
        return $response;
    }

    public function conversation($category){
        $quickReplies[] = QuickReplyElement::title('Company Name')->contentType('text')->payload('@company_name');
        $quickReplies[] = QuickReplyElement::title('Company Location')->contentType('text')->payload('@location');
        $quickReplies[] = QuickReplyElement::title('')->contentType('location')->payload('');

        return QuickReplyTemplate::toArray('Select options for search:', $quickReplies);
    } 

    public function location(Attachments $attachments){
        return LocationTemplate::toArray("Your Location", $attachments->getLat(), $attachments->getLong());
    }

    public function myQueueCards(){
        return "My Queue Cards";
    }

    public function userGuide(){
        return "User Guide";
    }
}