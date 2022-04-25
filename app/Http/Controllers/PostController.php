<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($topic_id)
    {
        $posts = Post::where(['topic_id' => $topic_id])->withCount('comments')->get();

        return response($posts, 200);
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
            'title' => 'required|string',
            'content' => 'required|string',
            'topic_id' => 'exists:topics,id'
        ]);

        $post = Post::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'user_id' => $user->id,
                'topic_id' => $request->get('topic_id')
        ]);

        PostVote::create([
            'value' => 1,
            'user_id' => $user->id,
            'post_id' => $post['id']
        ]);



        return response($post,201);
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
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where(['id' => $id])->with('comments')->with('user')->first();
        $views = $post->views;
        $views+=1;
        $post->update([
            'views' => $views
        ]);
        $post->save();
        return response($post,200 );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user = $request->user();
        $post = Post::where(['user_id' => $user->id , 'id' => $id])->with('comments')->first(); // make sure the post belongs to the user

        //$post = Post::with('comments')->find(['user_id' => $user->id , 'id' => $id]);
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'string'
        ]);

        $post->update($data);

        return response($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $post = Post::where(['user_id' => $user->id , 'id' => $id])->with('comments')->first(); // make sure the post belongs to the user
        $post->delete();
        return response(204);
    }

    public function user_posts(Request $request){

        $user = $request->user();
        $posts = Post::where(['user_id' => $user->id])->get();

        return response($posts,200);

    }


    public function top_posts(Request $request){


        $posts = Post::with('user')->withCount('comments')->get();
        return response($posts,200);
        $posts_with_recent_comments =  DB::table('posts')
        ->select(DB::raw('posts.*,users.username as username, count(post_id) as number_of_comments'))
        ->join ('comments','posts.id','=', 'comments.post_id')
        ->join('users','posts.user_id' , '=' , 'users.id')
        ->groupBy('id')
        ->orderBy('number_of_comments','desc')->get();

        return response($posts_with_recent_comments,200);
    }

    public function viewed_post(Request $request) {

    }

    public function vote(Request $request) {

        $user = $request->user();

        $request->validate([
            'value' => ['required', 'in:1,0,-1'],
            'post_id' => ['required' , 'exists:posts,id'],
        ]);

        $vote = PostVote::where(['post_id' => $request->get('post_id'), 'user_id' => $user->id])->first();
        if (empty($vote)) {
                  PostVote::create([
                'user_id' => $user->id,
                'post_id' => $request->get('post_id'),
                'value' => $request->get('value')
            ]);
            return response('', 201);
        } else if ($vote['value'] === $request->get('value')) {
            return response(['message' => 'user cannot vote twice on same post'], 403);
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
