<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    protected $fillable = [
        'sender_user_id' , 'receiver_user_id', 'message'
    ];


    // A message belongs to a sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user__id');
    }

    // A message also belongs to a receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }


}
