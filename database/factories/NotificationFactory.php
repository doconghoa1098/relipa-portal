<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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

        $divisionId = DB::table('divisions')->pluck('id');
        $createBy = DB::table('members')->pluck('created_by');

        return [
            'published_date' => $this->faker->date(),
            'subject' => $this->faker->name,
            'status' => rand(0, 3),
            'message' => $this->faker->name(),
            'attachment' => 'https://vnexpress.net/anh-dong-nghich-ngom-cua-meo-phan-4-2926836.html',
            'published_to' => json_encode([$this->faker->randomElement($divisionId)]),
            'created_by' => $this->faker->randomElement($createBy),
        ];
    }
}
