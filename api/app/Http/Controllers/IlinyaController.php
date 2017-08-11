<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ilinya\Webhook\Entry;
use App\Jobs\BotHandler;
use Illuminate\Support\Facades\Log;


class IlinyaController extends Controller
{
    public function hook(Request $request){
        $entries = Entry::getEntries($request);
        Log::info(print_r($entries, true));
        foreach ($entries as $entry) {
            $messagings = $entry->getMessagings();
            foreach ($messagings as $messaging) {
                dispatch(new BotHandler($messaging));
            }
        }
        return response("", 200);
    }

    public function broadcast(Request $request){
        $data = $request->all();
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
