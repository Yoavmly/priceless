<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    use HasFactory;

    protected $table = 'comments_votes';

    protected $fillable = [
        'comment_id' , 'value' , 'user_id'
    ];

    public function comment() {
        return $this->belongsTo(Comment::class);
    }
}
