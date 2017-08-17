<?php

namespace App\Ilinya\Message;

class Postback{

    function __construct(){

    }

    public function manage(){
        $action = $this->code->getCode($this->custom['payload']);
        switch ($action) {
          case $this->code->START:
            $this->bot->reply($this->response->start(), true);
            $this->bot->reply($this->response->categories(), false);
            break;
          case $this->code->USER_GUIDE:
            $this->bot->reply($this->response->userGuide(), true);
            break;
          case $this->code->MY_QUEUE_CARDS:
            $this->bot->reply($this->response->myQueueCards(), true);
            break;
          case $this->code->CATEGORIES:
            $this->bot->reply($this->response->categories(), false);
            break;
          case $this->code->CATEGORY_SELECTED:
            $this->bot->reply($this->search->options(), false);
            break;
          case $this->code->QUEUE_CARD:
            $this->bot->reply($this->forms->retrieve(), false);
            break;
          case $this->code->LOCATE:
            //Do Something
            break;
          case $this->code->NEXT:
            //Do Something
            break;
          case $this->code->SEND:
            //Do Something
            break;
          case $this->code->EDIT:
            //Do Something
            break;
          case $this->code->DISREGARD:
            //Do Something
            break;
          case $this->code->P_LIMIT:
            $this->bot->reply("Shutdown", true);
            break;
          default:
            $this->bot->reply($this->response->ERROR, true);
            break;
        }   
    }
}