<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyVoteFactory extends Factory
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
            'reply_id' => Reply::all()->random()->id
        ];
    }
}
