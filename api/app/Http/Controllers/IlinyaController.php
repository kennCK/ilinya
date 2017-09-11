<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ilinya\Webhook\Facebook\Entry;
use App\Jobs\BotHandler;
use App\Ilinya\Bot;
use App\Jobs\TestDatabaseQueryEffect;
use App\Ilinya\ImageGenerator;
class IlinyaController extends Controller
{
    public function hook(Request $request){
        $entries = Entry::getEntries($request);
        foreach ($entries as $entry) {
            $messagings = $entry->getMessagings();
            foreach ($messagings as $messaging) {
                dispatch(new BotHandler($messaging));
            }
        }
        return response("", 200);
    }

    public function broadcast($companyId){
        //$data = $request->all();
        $message = "test";
        $recepientId = "1756273174387070";
        Bot::notify($recepientId, $message);
    }

    public function paging($recepientId, $message){
        Bot::notify($recepientId, $message);
    }

    public function reminder($recepientId, $message){
        Bot::notify($recepientId, $message);
    }

    public function createImage(){
        ImageGenerator::create();
    }

    public function test($size){
        dispatch(new TestDatabaseQueryEffect($size));
    }
}
