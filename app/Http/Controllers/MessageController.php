<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return auth()->user()->conversations()->with('messages')->get();
    }

    public function store(Request $request)
    {
        $conversation = auth()->user()->conversations()->findOrFail($request->conversation_id);

        $message = $conversation->messages()->create($request->only('content'));

        return $message;
    }

    public function view($id)
    {
        return auth()->user()->conversations()->with('messages')->findOrFail($id);

    }
}
