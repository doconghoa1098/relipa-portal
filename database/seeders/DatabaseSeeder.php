<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Notification;
use App\Models\Request;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //Member::factory(10)->create();
        // Notification::factory(10)->create();
        Request::factory(10)->create();

    }
}
