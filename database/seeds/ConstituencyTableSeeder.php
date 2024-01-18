<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConstituencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data from the table
        DB::table('Constituencies')->truncate();

        // Add new data
        $constituencies = [
            ['name' => 'Shangri-la-Town'],
            ['name' => 'Northern-Kunlun-Mountain'],
            ['name' => 'Western-Shangri-la'],
            ['name' => 'Naboo-Vallery'],
            ['name' => 'New-Felucia'],
            // Add more constituencies as needed
        ];

        // Insert data into the 'Constituency' table
        DB::table('Constituencies')->insert($constituencies);
    }
}
