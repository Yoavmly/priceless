<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyVote extends Model
{
    use HasFactory;

    protected $table = 'replies_votes';

    protected $fillable = [
        'reply_id' , 'value' , 'user_id'
    ];

    public function reply() {
        return $this->belongsTo(Reply::class);
    }
}
