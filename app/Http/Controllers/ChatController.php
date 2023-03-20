<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Predis;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendMessage()
    {
        $redis = PRedis::connection();

        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];

        $redis->publish('message', json_encode($data));

        return response()->json(['success' => true]);
    }
}
