<?php

namespace App\Http\Controllers;

use App\Models\Message;

use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $user = $request->user();
        // validate
        $request->validate([
            'sender_user_id' => ['required', Rule::in($user->id)],
            'receiver_user_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);


        $message = Message::create([
            'sender_user_id' => $user->id,
            'receiver_user_id' => $request->get('receiver_user_id'),
            'message' => $request->get('message'),
        ]);

        $user_receiver = User::find($request->get('receiver_user_id'));
        $user_receiver->notify(new NewMessage('You got a new message',$message->id, $user->username));

        return response($message, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = $request->user();


//        $message = Message::where(['id' => $request->get('id')])->where(function ($query) use ($user) {
//            $query->where('sender_user_id', $user->id)
//                ->orWhere('receiver_user_id', $user->id);
//        })->first();

        $message = Message::where(['id' => $request->get('id'),'sender_user_id'=> $user->id])->first();


        if (!empty($message)) {
            $message->delete();
            return response(['message' => 'message deleted successfully'], 200);
        }


        return response(['message' => "Message doesn't exist"], 400);

    }

    public function get_conversation(Request $request)
    {
        $user = $request->user();
        $otherUserId = $request->get('otherUserId');
        $otherUser = User::find($otherUserId);
        $messages = Message::where(function ($query) use ($user, $otherUserId) {
            $query->where('sender_user_id', $user->id)
                ->orWhere('receiver_user_id', $otherUserId);
        })->orwhere((function ($query) use ($user, $otherUserId) {
            $query->where('sender_user_id', $otherUserId)
                ->orWhere('receiver_user_id', $user->id);
        }))->get();
        return response($messages,200);


    }
}
