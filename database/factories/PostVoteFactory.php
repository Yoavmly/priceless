<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostVoteFactory extends Factory
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
            'post_id' => Post::all()->random()->id
        ];
    }
}
