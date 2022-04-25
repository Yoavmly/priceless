<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(180),
            'user_id' => User::all()->random()->id,
            'comment_id' => Comment::all()->random()->id,
            'upvotes' => random_int(0,20),
            'downvotes' => random_int(0,20)
        ];
    }
}
