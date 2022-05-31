<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id' => Member::pluck('id')->random(),
            'request_type' => rand(1,5),
            'request_for_date' => $this->faker->date(),
            'leave_all_day' => random_int(0, 1),
            'status' => rand(-1, 2),
            'manager_confirmed_status' => random_int(0, 1),
            'admin_approved_status' => random_int(0, 1),
            'error_count' => random_int(0, 1),
        ];
    }
}
