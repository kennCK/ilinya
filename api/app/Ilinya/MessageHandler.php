<?php
namespace App\Ilinya;

use App\Ilinya\MessageExtractor;
use App\Ilinya\Tracker;
use App\Ilinya\Message\Facebook\Attachments;
use App\Ilinya\Message\Facebook\Codes;
use App\Ilinya\Message\Facebook\Error;
use App\Ilinya\Message\Facebook\Postback;
use App\Ilinya\Message\Facebook\QuickReply;
use App\Ilinya\Message\Facebook\Text;
use App\Ilinya\Webhook\Facebook\Messaging;

class MessageHandler{
  protected $types = array('postback', 'message', 'read', 'delivery');
  
  protected $currentCode;
  protected $reply;
  protected $searchOption;
  protected $stage;
  protected $prevStage;
  protected $companyId;
  protected $category;


  protected $tracker;
  protected $trackerFlag;

  protected $code;
  protected $custom;

  protected $postback;
  protected $messaging;
  protected $quickReply;


  protected $response;
  function __construct(Messaging $messaging){
    $this->messaging  = $messaging;
    $this->tracker    = new Tracker($messaging);
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
    $this->code       = new Codes();
    $this->postback   = new Postback($messaging);
    $this->quickReply = new QuickReply($messaging);
    $this->trackerFlag    = 0;
  }

  public function manage(){
    $this->response = $this->tracker->getStatus($this->custom);
    $this->currentCode = $this->code->getCode($this->custom);
    switch ($this->response['status']) {
      case $this->code->read:
        $this->trackerFlag    = 0;
        //Read
        break;
      case $this->code->delivery:
        $this->trackerFlag    = 0;
        //Delivery
        break;
      case $this->code->pStart:
        $this->trackerFlag = 1;
        $this->postback->manage($this->custom);
        $this->trackerHandler();
        break;
      case $this->code->postback:
        $this->trackerFlag = 2;
        $this->getParameter();  
        $this->trackerHandler();
        $this->postback->manage($this->custom);  
        break;
      case $this->code->message:
        $this->message();
        break;
      case $this->code->error:
        //Error
        break;
      default:
        //Do Nothing
        break;
    }
  }

  public function trackerHandler(){
    switch ($this->trackerFlag) {
      case 1: // Insert
            $this->tracker->insert($this->currentCode, $this->response['stage'], $this->category);
        break;
      case 2: // Update
            $data = [
                "status"            => $this->currentCode
            ];
            if($this->reply)$data['reply']  = $this->reply;
            if($this->searchOption)$data['search_option'] = $this->searchOption;
            if($this->category)$data['business_type_id'] =  $this->category;
            if($this->stage)$data['stage'] = $this->stage;
            if($this->companyId)$data['company_id'] = $this->companyId;
            $this->tracker->update($data);
        break;
      case 3:
            $data['reply']  = $this->reply;
            $this->tracker->update($data);
        break;
      case 4: // Delete
        break;
      default:
        break;
    }
  }
  public function getParameter(){
    $code = $this->code->getCode($this->custom);
    switch ($code) {
      case $this->code->pCategorySelected:
        $this->category =  $this->custom['parameter'];
        break;
      case $this->code->pGetQueueCard:
        $this->companyId = $this->custom['parameter'];
        break;
      default:
        # code...
        break;
    }
  }

  public function message(){
        if($this->custom['attachments']){
            //Attachments
            $attachments = new Attachments($this->custom['attachments']);
            $response;
            if($attachments->getType() == "location"){
                $response = $this->response->location($attachments);
            }
            else{
            }
        }
        else if($this->custom['quick_reply']){
            $this->quickReply->manage($this->custom);
        }
        else if($this->custom['text']){
            //Text
        } 
  }
}