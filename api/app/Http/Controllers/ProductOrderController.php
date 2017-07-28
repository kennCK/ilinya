<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductOrder as Item;
use Mail;
class ProductOrderController extends APIController
{
  function __construct(){
    $this->model = new Item();
    $this->validation = array(
    );
    $this->defaultValue = array(
      'rice_option' => 0,
      'barley_option' => 0,
      'basmati_option' => 0,
    );
    $this->foreignTable = array(
      'product'
    );
    $this->validation = array(
      'email' => 'email'
    );
    $this->requiredForeignTable = array(
      'product'
    );
    $this->notRequired = array('rice_option', 'barley_option', 'basmati_option', 'status');
  }

  public function create(Request $request){
    $reqArray = $request->all();
    $this->createEntry($reqArray);
    if($this->response['data'] * 1){
      $this->response["debug"][] = (time().$this->response['data'].time()*1);
      $this->response["debug"][] = $request->email;
      $this->response["debug"][] = Mail::send([], ['request' =>$request],  function($message) use ($request){
          $message->to($request->email)
            ->subject('FineGrabz Order Confirmation')
            ->setBody(
                'Good day! ' . $request->name
                . "\n\n   Please click the link below for confirmation. "
                . url('api/confirm_order/'.time().$this->response['data'].time())."\n\n Regards,\nFinegrabz");
        });

    }



    return $this->output();
  }
  public function confirmOrder($confirmation_code){
    $this->updateEntry(array(
      'id' => substr(substr($confirmation_code, 10), 0, -10),
      'status' => 1
    ));
    header('Location: '.'http://www.finegrabz.johnenrick.com/#/order_confirmed');
  }
}
