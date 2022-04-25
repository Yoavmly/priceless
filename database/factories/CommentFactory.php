<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
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
            'post_id' => Post::all()->random()->id,
            'upvotes' => random_int(0,20),
            'downvotes' => random_int(0,20)
        ];
    }
}
