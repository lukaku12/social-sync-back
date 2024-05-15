<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class ConversationController extends Controller
{
    public function index(): JsonResponse
    {
        $conversations = auth()
            ->user()
            ->conversations()
            ->with(['messages', 'members'])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->max('created_at');
            });

        return response()->json(ConversationResource::collection($conversations));
    }

    //    public function store(Request $request)
    //    {
    //        $conversation = auth()->user()->conversations()->create($request->only('name'));
    //
    //        return $conversation;
    //    }

    //    public function show($id)
    //    {
    //        return auth()->user()->conversations()->with('messages')->findOrFail($id);
    //    }

    public function messages($uuid)
    {
        $conversation = Conversation::where('uuid', $uuid)->firstOrFail();

        $messages = $conversation->messages()
            ->with(['sender', 'views'])
            ->orderBy('created_at', 'ASC')
            ->get();

        $final = [];
        $index = 0;

        if ($messages->count() > 0) {

            $final[$index] = [];
            $final[$index][] = $messages[0];
            $index++;

            for ($i = 1; $i < $messages->count(); $i++) {
                if ($messages[$i]->sender_id == $messages[$i - 1]->sender_id) {
                    $final[$index - 1][] = $messages[$i];
                } else {
                    $final[$index] = [];
                    $final[$index][] = $messages[$i];
                    $index++;
                }
            }

        }

        return response()->json($final);
    }

    public function storeMessage($uuid): JsonResponse
    {
        $conversation = Conversation::where('uuid', $uuid)->firstOrFail();

        $request = \request()->all();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'content' => $request['content'],
        ]);

        $message->load(['sender', 'views']);

        broadcast(new GotMessage($uuid, $message))->toOthers();

        return response()->json($message);
    }
    //
    //    public function update(Request $request, $id)
    //    {
    //        $conversation = auth()->user()->conversations()->findOrFail($id);
    //
    //        $conversation->update($request->only('name'));
    //
    //        return $conversation;
    //    }
    //
    //    public function destroy($id)
    //    {
    //        $conversation = auth()->user()->conversations()->findOrFail($id);
    //
    //        $conversation->delete();
    //
    //        return response()->noContent();
    //    }
}
