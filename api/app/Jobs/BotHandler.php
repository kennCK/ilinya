<?php

namespace App\Jobs;

use App\Ilinya\Bot;
use App\Ilinya\Ilinya;
use App\Ilinya\Webhook\Messaging;

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
                $bot->reply($ilinya->start());
                $bot->reply($ilinya->categories());
            }
            else if($custom['payload'] == $ilinya->CATEGORIES){
                $bot->reply($ilinya->categories());
            }
            else if($custom['payload'] == $ilinya->MY_QUEUE_CARDS){
                $bot->reply($ilinya->myQueueCards());
            }
            else if($custom['payload'] == $ilinya->USER_GUIDE){
               $bot->reply($ilinya->userGuide());
            }
            else if($priority == 'categories'){
                $bot->reply($ilinya->conversation($category));
            }
            else if($custom['payload'] == $ilinya->CONVERSATION){
                $bot->reply($custom['title']);
            }
            else{
                $bot->reply("I'm sorry but I can't do what you want me to do :'(");
            }
        }
        else if($custom['type'] == "message"){
        }

        
    }
}
