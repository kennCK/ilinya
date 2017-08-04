<?php

namespace App\Jobs;

use App\Ilinya\Bot;
use App\Ilinya\Ilinya;
use App\Ilinya\Webhook\Messaging;
use App\Ilinya\Message\Attachments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Cache;
class BotHandler implements ShouldQueue{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messaging;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
    }
    /**
     * Execute the job.
     *
     * @param Messaging $messaging
     */
    public function handle(){
        $bot = new Bot($this->messaging);
        $ilinya = new Ilinya($this->messaging);
        $custom = $bot->extractData();


        if($custom['type'] == "postback"){
            list($priority, $category) = explode('@', $custom['payload']);

            if($custom['payload'] == $ilinya->GET_STARTED){
                $bot->reply($ilinya->start(), true);
                $bot->reply($ilinya->categories(), false);
            }
            else if($custom['payload'] == $ilinya->CATEGORIES){
                $bot->reply($ilinya->categories(), false);
            }
            else if($custom['payload'] == $ilinya->MY_QUEUE_CARDS){
                $bot->reply($ilinya->myQueueCards(), true);
            }
            else if($custom['payload'] == $ilinya->USER_GUIDE){
               $bot->reply($ilinya->userGuide(), true);
            }
            else if($priority == 'categories'){
                $bot->reply($ilinya->conversation($category), false);
            }
            else{
                $bot->reply($ilinya->ERROR, true);
            }
        }
        else if($custom['type'] == "message"){
            /*
                
                @Check if Message Contains Attachments, Quick Reply or Text
            
            */

            $response = "";
            if($custom['attachments']){
                /*

                    @Check type of attachments

                */
                $attachments = new Attachments($custom['attachments']);
                $response;
                if($attachments->getType() == "location"){
                    $response = $ilinya->location($attachments);
                }
                else{

                }
                $bot->reply($response, false);
            }
            else if($custom['quick_reply']){

            }
            else if($custom['text']){
                $bot->reply($custom['text'], true);
            } 
        }
        else if($custom['type'] == "read"){
            //Code Here
        }
        else if($custom['type'] == "delivery"){
            //Code here
        }
        
    }
}
