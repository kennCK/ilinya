<?php

namespace App\Ilinya\Message;


class Codes{

  /**
    Read Priority Codes
  */

  public $READ          = 0;

  /**
    Delivery Priority Codes
  */

  public $DELIVERY      = 100;

  /**
    Postback Priority Codes
  */

  public $POSTBACK      = 200;

  public $P_START       = 201;

  public $P_USERGUIDE   = 202;

  public $P_QUEUECARDS  = 203;

  public $P_CATEGORIES  = 204;

  public $P_CATEGORY_SELECTED = 205;

  public $P_LIMIT       = 205;

  /**
    Message Priority Codes
  */

  public $MESSAGE       = 300;

  public $M_QR          = 301;

  public $M_ATTACHMENT  = 302;

  public $M_TEXT        = 303;

  public $QR_SEARCH     = 304;


  protected $PREDEFINED   = array();

  function __construct(){
    $this->PREDEFINED = array(
      "read"                => $this->READ,
      "delivery"            => $this->DELIVERY,
      "postback"            => $this->POSTBACK,
      "@start"              => $this->P_START,
      "@users_guide"        => $this->P_USERGUIDE,
      "@my_queue_cards"     => $this->P_QUEUECARDS,
      "@categories"         => $this->P_CATEGORIES,
      "@categoryselected"   => $this->P_CATEGORY_SELECTED,
      "message"             => $this->MESSAGE,
      "quick_reply"         => $this->M_QR,
      "attachments"         => $this->M_ATTACHMENT,
      "text"                => $this->M_TEXT,
      "@search"             => $this->QR_SEARCH
    );
  }

  public function getCode($action){
    return $this->PREDEFINED[$action];
  }

  public function getCodeByUnknown($custom){
    $code = null;
    switch ($custom['type']) {
      case 'read':
        $code = $this->READ;
        break;
      case 'delivery':
        $code = $this->DELIVERY;
        break;
      case 'postback':
        $code = $this->getCodeInPostback($custom['payload']);
        break;
      case 'message':
        $code = $this->getCodeInMessage($custom);
    }
    return $code;
  }

  public function getCodeInPostback($payload){
    $code = null;
      switch ($payload) {
        case '@start':
          $code = $this->P_START;
          break;
        case '@users_guide':
          $code = $this->P_USERGUIDE;
          break;
        case '@my_queue_cards':
          $code = $this->P_QUEUECARDS;
          break;
        case '@categories':
          $code = $this->P_CATEGORIES;
          break;
        case '@categoryselected':
          $code = $this->P_CATEGORY_SELECTED;
          break;
        default:
          $code = $this->POSTBACK;
          break;
      }
    return $code;
  }

  public function getCodeInMessage($messageType){
    if($messageType['attachments'])return $this->M_ATTACHMENT;
    else if($messageType['quick_reply'])return $this->getCodeInQuickReply($messageType['quick_reply']['payload']);
    else if($messageType['text'])return $this->M_TEXT;
    else return $this->MESSAGE;
  }

  public function getCodeInQuickReply($payload){
    switch ($payload) {
      case '@search':
        return $this->QR_SEARCH;
        break;
    }
  }


}