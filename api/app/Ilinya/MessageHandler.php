<?php
namespace App\Ilinya;

use App\Ilinya\Message\Codes;
use App\Ilinya\Message\Attachments;
use App\Ilinya\Bot;
use App\Ilinya\StatusChecker;
use App\Ilinya\MessageExtractor;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Response\Introduction;
use App\Ilinya\Response\Search;
use App\Ilinya\Response\Forms;


class MessageHandler{
  protected $checker;
  protected $response;
  protected $bot;
  protected $custom;
  protected $search;

  protected $types = array('postback', 'message', 'read', 'delivery');

  protected $code;

  protected $currentCode;

  protected $reply;

  protected $searchOption;

  protected $stage;

  protected $companyId;

  protected $category;

  function __construct(Messaging $messaging){
    $this->checker    = new StatusChecker($messaging);
    $this->response   = new Introduction($messaging); 
    $this->search     = new Search($messaging);
    $this->forms      = new Forms($messaging, $this->checker);
    $this->bot        = new Bot($messaging);
    $this->code       = new Codes();
    $messageExtractor = new MessageExtractor($messaging); 
    $this->custom     = $messageExtractor->extractData();
  }

  public function manage(){
    $stage = $this->code->P_START;
    $dbTrack = false;
    $status = $this->checker->getStatus($this->custom);
    $this->currentCode = $this->code->getCodeByUnknown($this->custom);
    switch ($status) {
      case 0:
        //Do Nothing
        break;
      case 100:
        //Do Nothing
        break;
      case 200: 
        Postback::manage();
        $dbTrack = 2;
        $this->getParameter();    
        break;
      case 300:
        $this->message();
        $dbTrack = 2;
        break;
      case 400:
        $this->bot->reply($this->response->priorityError(), false);
        break;
      default:
        //Do Nothing
        break;
    }
    if($dbTrack == 1){
        //Create
        $this->checker->insert($this->currentCode, $stage, $this->category);
    }
    else if($dbTrack == 2 && $this->currentCode != $this->code->M_TEXT){
        $data = [
            "status"            => $this->currentCode
        ];
        if($this->reply)$data['reply']  = $this->reply;
        if($this->searchOption)$data['search_option'] = $this->searchOption;
        if($this->category)$data['business_type_id'] =  $this->category;
        if($this->stage)$data['stage'] = $this->stage;
        if($this->companyId)$data['company_id'] = $this->companyId;
        $this->checker->update($data);
    }
    else if($dbTrack == 2 && $this->currentCode == $this->code->M_TEXT){
        $data['reply']  = $this->reply;
        $this->checker->update($data);
    }
  }

  public function getParameter(){

    switch ($this->custom['payload']) {
      case '@categoryselected':
        $this->category =  $this->custom['parameter'];
        break;
      case '@get_queue_cards':
        $this->companyId = $this->custom['parameter'];
        break;
      default:
        # code...
        break;
    }
  }

  public function message(){
        $response = "";
        if($this->custom['attachments']){
            $attachments = new Attachments($this->custom['attachments']);
            $response;
            if($attachments->getType() == "location"){
                $response = $this->response->location($attachments);
            }
            else{
            }
        }
        else if($this->custom['quick_reply']){
            $this->quickReply();
        }
        else if($this->custom['text']){
            $this->replyHandler();
            
        } 
  }
}