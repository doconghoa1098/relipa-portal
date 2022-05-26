<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'member_code' => $this->faker->regexify('[A-Z0-9]{10}'),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456'),
            'gender'=> random_int(0, 1),
            'marital_status' => 1,
            'birth_date' => $this->faker->dateTimeThisMonth(),
            'permanent_address' => $this->faker->address(),
            'temporary_address' => $this->faker->address(),
            'identity_number' => $this->faker->regexify('[0-9]{9,12}'),
            'identity_card_date' => $this->faker->date(),
            'identity_card_place' => 'long đẹp trai',
            'nationality' => 'Việt Nam',
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_relationship' => $this->faker->name(),
            'emergency_contact_number' => rand(1,100),
            'bank_name' => $this->faker->name(),
            'bank_account' => rand(1,100),
            'status' => rand(-1,5),
            'created_by' => rand(1,100),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {

            return [
                'email_verified_at' => null,
            ];
        });
    }
}
