<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorksheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $member_id = Member::pluck('id')->toArray();
        return [
            'member_id' => $this->faker->randomElement($member_id),
            'work_date' => $this->faker->date(),
            'checkin' => $this->faker->date(),
            'checkin_original' => $this->faker->date(),
            'checkout'=> $this->faker->date(),
            'checkout_original' => $this->faker->date(),
            'late' => $this->faker->date('H:i'),
            'early' => $this->faker->date('H:i'),
            'in_office' => $this->faker->date('H:i'),
            'ot_time' => $this->faker->date('H:i'),
            'work_time' => $this->faker->date(),
            'lack' => $this->faker->date('H:i'),
            'compensation' => $this->faker->date('H:i'),
            'paid_leave' => $this->faker->date('H:i'),
            'unpaid_leave' => $this->faker->date('H:i'),
            'note' => $this->faker->name(),
        ];
    }
}
