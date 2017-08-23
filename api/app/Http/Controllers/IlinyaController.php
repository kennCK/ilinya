<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ilinya\Webhook\Facebook\Entry;
use App\Jobs\BotHandler;
use App\Ilinya\Bot;


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

    public function broadcast(Request $request){
        //$data = $request->all();
        $message = "test";
        $recepientId = "1756273174387070";
        Bot::notify($recepientId, $message);
        return "broadcast";
    }

    public function paging(Request $request){
        $data = $request->all();
        return "paging";
    }

    public function reminder(Request $request){
        $data = $request->all();
        return "reminder";
    }
}
