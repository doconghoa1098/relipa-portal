<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'published_date' => $this->faker->date(),
            'subject' => $this->faker->name(),
            'message' => $this->faker->text(),
            'status' => 0,
            'attachment' => $this->faker->name(),
            'published_to' => json_encode('longdeptrai'),
            'created_by' => rand(1,100),
        ];
    }
}
