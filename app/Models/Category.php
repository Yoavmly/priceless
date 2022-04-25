<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;



    public function topics() {
        return $this->hasMany(Topic::class);
    }

    public function posts() {
        return $this->hasManyThrough(Post::class,Topic::class);
    }
}
