<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use App\Models\ReplyVote;
use App\Models\User;
use App\Notifications\NewReply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string',

        ]);

        $reply = Reply::create([
            'comment_id' => $request->get('comment_id'),
            'content' => $request->get('content'),
            'user_id' => $user->id
        ]);

        $comment = Comment::findOrFail($request->get('comment_id'));
        $user_id  = $comment->user_id;
        $user = User::find($user_id);

        $user->notify(new NewReply('New Reply To your comment'));

        return response($reply, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $reply = Reply::where(['user_id' => $user->id , 'id' => $id])->first(); // make sure the post belongs to the user

        //$post = Post::with('comments')->find(['user_id' => $user->id , 'id' => $id]);
        $data = $request->validate([
            'content' => 'required|string'
        ]);

        $reply->update($data);

        return response($reply, 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $user = $request->user();
        $reply = Reply::where(['user_id' => $user->id , 'id' => $id])->first(); // make sure the reply belongs to the user
        $reply->delete();
        return response('', 204);
    }

    public function vote(Request $request) {

        $user = $request->user();

        $request->validate([
            'value' => ['required', 'in:1,0,-1'],
            'reply_id' => ['required' , 'exists:replies,id'],
        ]);

        $vote = ReplyVote::where(['reply_id' => $request->get('reply_id'), 'user_id' => $user->id])->first();
        if (empty($vote)) {
            ReplyVote::create([
                'user_id' => $user->id,
                'reply_id' => $request->get('reply_id'),
                'value' => $request->get('value')
            ]);
            return response('', 201);
        } else if ($vote['value'] === $request->get('value')) {
            return response(['message' => 'user cannot vote twice on same reply'], 403);
        } else if($vote['value'] !== $request->get('value')) {
            $vote->update([
                'value' => $request->get('value') + $vote['value']
            ]);
            return response('', 201);
        } else {
            return response(['message' => 'Something went wrong'], 400);
        }
    }
}
