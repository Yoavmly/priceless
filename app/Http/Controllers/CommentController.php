<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewComment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user(); // this is a protected route - we want to make sure only auth users get this information

        $request->validate([
            'post_id' => 'exists:comments,post_id'
        ]);

        $comments = Comment::find('post_id' , $request->get('post_id'))->with('replies');

        return response($comments, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Log::info(print_r($request->all()));
        $commenting_user = $request->user();

       $request->validate([
           'post_id' => 'required|exists:posts,id',
           'content' => 'required|string',

        ]);

        $comment = Comment::create([
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content'),
            'user_id' => $commenting_user->id
        ]);

        $post = Post::findOrFail($request->get('post_id'));
        $user_id  = $post->user_id;
        $user = User::find($user_id);

        $user->notify(new NewComment('New Comment To your post' , $post->id ,$commenting_user->username ));

        return response($comment, 201);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function vote(Request $request) {

        $user = $request->user();

        $request->validate([
            'value' => ['required', 'in:1,0,-1'],
            'comment_id' => ['required' , 'exists:comments,id'],
        ]);

        $vote = CommentVote::where(['comment_id' => $request->get('comment_id'), 'user_id' => $user->id])->first();
        if (empty($vote)) {
            CommentVote::create([
                'user_id' => $user->id,
                'comment_id' => $request->get('comment_id'),
                'value' => $request->get('value')
            ]);
            return response('', 201);
        } else if ($vote['value'] === $request->get('value')) {
            return response(['message' => 'user cannot vote twice on same comment'], 403);
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
