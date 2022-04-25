<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostVote extends Model
{
    use HasFactory;

    protected $table = 'posts_votes';

    protected $fillable = [
        'post_id' , 'value' , 'user_id'
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
