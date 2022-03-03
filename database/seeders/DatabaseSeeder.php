<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $seeders = [
        CitiesSeeder::class => 'cities',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeders as $seed => $table) {
            if(!\DB::table($table)->first()) {
                $this->call($seed);
            }
        }
    }
}
