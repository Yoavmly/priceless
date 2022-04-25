<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'value' => $this->faker->numberBetween(-1,1),
            'user_id' => User::all()->random()->id,
            'comment_id' => Comment::all()->random()->id
        ];
    }
}
