<?php
namespace App\Ilinya;

use App\Ilinya\MessageExtractor;
use App\Ilinya\StatusChecker;
use App\Ilinya\Message\Attachments;
use App\Ilinya\Message\Codes;
use App\Ilinya\Message\Error;
use App\Ilinya\Message\Postback;
use App\Ilinya\Message\QuickReply;
use App\Ilinya\Message\Text;
use App\Ilinya\Webhook\Messaging;

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

  protected $code;
  protected $checker;
  protected $custom;

  protected $postback;
  protected $messaging;
  protected $quickReply;

  function __construct(Messaging $messaging){
    $this->messaging  = $messaging;
    $this->checker    = new StatusChecker($messaging);
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
    $this->code       = new Codes();
    $this->postback   = new Postback($messaging);
    $this->quickReply = new QuickReply($messaging);
    $this->tracker    = 0;
  }

  public function manage(){
    $this->prevStage = $this->checker->getStage();
    $status = $this->checker->getStatus($this->custom);
    $this->currentCode = $this->code->getCode($this->custom);
    switch ($status) {
      case $this->code->read:
        //Read
        break;
      case $this->code->delivery:
        //Delivery
        break;
      case $this->code->postback:
        $this->postback->manage($this->custom);
        //$this->tracker = 2;
        //$this->getParameter();    
        break;
      case $this->code->message:
        $this->message();
        //$this->tracker = 3;
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
    switch ($this->tracker) {
      case 1: // Insert
            $this->checker->insert($this->currentCode, $stage, $this->category);
        break;
      case 2:
            $data = [
                "status"            => $this->currentCode
            ];
            if($this->reply)$data['reply']  = $this->reply;
            if($this->searchOption)$data['search_option'] = $this->searchOption;
            if($this->category)$data['business_type_id'] =  $this->category;
            if($this->stage)$data['stage'] = $this->stage;
            if($this->companyId)$data['company_id'] = $this->companyId;
            $this->checker->update($data);
        break;
      case 3:
            $data['reply']  = $this->reply;
            $this->checker->update($data);
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