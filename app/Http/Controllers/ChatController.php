<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Predis;

class ChatController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function sendMessage()
    {
        $redis = PRedis::connection();

        $data = ['message' => FacadesRequest::input('message'), 'user' => FacadesRequest::input('user')];

        $redis->publish('message', json_encode($data));

        return response()->json(['success' => true]);
    }

    public function login()
    {
        return view('auth.login');
    }
}
