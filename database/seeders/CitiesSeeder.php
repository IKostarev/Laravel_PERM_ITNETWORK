<?php

namespace Database\Seeders;

use App\Models\Cities;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cities::factory()
            ->count(10)
            ->create();
    }
}
