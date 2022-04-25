<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register' , [AuthController::class,'register']);
Route::post('/login' , [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::post('/logout', [AuthController::class,'logout']);
});

Route::controller(CategoryController::class)->prefix('categories')->group(function (){
    Route::get('/', [CategoryController::class,'index']);
    Route::get('/{id}' , [CategoryController::class,'show']);
});

Route::controller(TopicController::class)->prefix('topics')->group(function (){
    Route::get('/{category_id}', [TopicController::class,'index']);
    Route::post('/' , [TopicController::class, 'create']);
    Route::delete('/topic/{id}', [TopicController::class,'destroy']);
    Route::get('/topic/all', [TopicController::class,'all']);
    Route::get('/topic/{id}',[TopicController::class,'show']);
});

Route::controller(PostController::class)->prefix('posts')->group(function (){
    Route::get('/{topic_id}' , [PostController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/' , [PostController::class, 'create']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::middleware('auth:sanctum')->put('/post/{id}' , [PostController::class, 'update']);
    Route::middleware('auth:sanctum')->delete('/post/{id}', [PostController::class,'destroy']);
    Route::middleware('auth:sanctum')->get('/user/user_posts',[PostController::class,'user_posts']);
    Route::get('/top/top_posts' , [PostController::class,'top_posts']);
    Route::middleware('auth:sanctum')->post('/vote' , [PostController::class,'vote']);
});

Route::controller(CommentController::class)->prefix('comments')->group(function (){
    Route::middleware('auth:sanctum')->post('/', [CommentController::class,'create']);
    Route::middleware('auth:sanctum')->post('/vote', [CommentController::class,'vote']);
});

Route::controller(ReplyController::class)->prefix('replies')->group(function (){
    Route::middleware('auth:sanctum')->post('/', [ReplyController::class,'create']);
    Route::middleware('auth:sanctum')->delete('/reply/{id}', [ReplyController::class,'destroy']);
    Route::middleware('auth:sanctum')->put('/reply/{id}', [ReplyController::class,'update']);
    Route::middleware('auth:sanctum')->post('/vote', [ReplyController::class,'vote']);
});

Route::controller(NotificationController::class)->prefix('notifications')->group(function (){
    Route::middleware('auth:sanctum')->get('/', [NotificationController::class,'getNotifications']);

});

Route::post('/password/email', [AuthController::class,'sendPasswordResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
Route::post('/password/reset', [AuthController::class,'resetPassword'])->name('password.reset');
Route::get('/email/verify/{id}', [AuthController::class , 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::middleware('auth:sanctum')->get('/email/resend', [AuthController::class , 'resend'])->name('verification.resend');



Route::controller(NotificationController::class)->prefix('messages')->group(function (){
    Route::middleware('auth:sanctum')->post('/', [MessageController::class,'create']);
    Route::middleware('auth:sanctum')->delete('/', [MessageController::class,'destroy']);
    Route::middleware('auth:sanctum')->get('/conversation', [MessageController::class,'get_conversation']);
});
