<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data from the table
        DB::table('parties')->truncate();

        // Add new data
        $parties = [
            ['name' => 'Blue Party'],
            ['name' => 'Red Party'],
            ['name' => 'Yellow Party'],
            ['name' => 'Independent'],
            // Add more parties as needed
        ];

        // Insert data into the 'party' table
        DB::table('parties')->insert($parties);

    }
}
