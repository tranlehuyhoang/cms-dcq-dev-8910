<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMission;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChatController extends BaseController
{
    public function index()
    {
        $authUserId = Auth::user()->id;
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $users = User::where('id', '!=', $authUserId)->where('name', 'like', '%' . $searchTerm . '%')->get();
        }else {
            $users = User::where('id', '!=', $authUserId)->get();
        }

        foreach ($users as $user) {
            $chatRoom = $user->getChatRoom($user->id, $authUserId);
            $user->chatRoom = $chatRoom;
            $latestChat = $user->getLatestChat($user->chatRoom->id ?? null, $user->id);
            $user->latestChat = $latestChat;
        }
        $sortedUsers = $users->sortByDesc(function ($user) {
            return optional($user->latestChat->id ?? null) ;
        });

        return view('chat.index', compact('sortedUsers'));
    }
    public function getChatsInRoom(  $user_id )
    {
        $authUserId = Auth::user()->id;
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $users = User::where('id', '!=', $authUserId)->where('name', 'like', '%' . $searchTerm . '%')->get();
        }else {
            $users = User::where('id', '!=', $authUserId)->get();
        }
        foreach ($users as $user) {
            $chatRoom = $user->getChatRoom($user->id, $authUserId);
            $user->chatRoom = $chatRoom;
            $latestChat = $user->getLatestChat($user->chatRoom->id ?? null, $user->id);
            $user->latestChat = $latestChat;
        }

        $sortedUsers = $users->sortByDesc(function ($user) {
            return optional($user->latestChat->id ?? null) ;
        });

        $otherUser = User::find($user_id);
        $chatRoom = $otherUser->getChatRoom(intval($user_id), $authUserId);
        if (!$chatRoom) {
            $newChatRoom = new ChatRoom();
            $chat_room_users = json_encode([intval($user_id), intval($authUserId)]);
            $newChatRoom->user_id =  $chat_room_users ;
            $newChatRoom->save();
            $chatRoom = $newChatRoom;
        }
        $chats = ChatMission::where('chat_id', $chatRoom->id)->get();

        return view('chat.index', compact('sortedUsers', 'chats', 'otherUser','chatRoom'));
    }
    public function store( Request $request )
    {
        $sender_id = Auth::user()->id;
        $newChatMission = ChatMission::create([
			'sender_id' => $sender_id,
			'chat_id' =>  $request->input('chat_id'),
			'note' =>  $request->input('note')
		]);
        return redirect()->back();
    }
}
