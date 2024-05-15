<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ConversationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{

    public function index(): JsonResponse
    {
        $userContacts = auth()->user()->contacts()->get();

        return response()->json($userContacts);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = User::findOrFail($request->contact_id);

        if ($contact->id === auth()->id()) {
            return response()->json(['message' => 'You cannot send a friend request to yourself']);
        }

        auth()->user()->contacts()->attach($contact);

        $contact->contacts()->attach(auth()->user());

        //        $friend->notify(new FriendRequestReceived(auth()->user()));

        return response()->json(['message' => 'Friend request sent', 'data' => 'friend_id' . $contact]);
    }

}
