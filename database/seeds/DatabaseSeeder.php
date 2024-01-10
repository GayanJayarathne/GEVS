<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $testUser = User::create([
            'name' => 'Commission Officer',
            'email' => 'election@shangrila.gov.sr',
            'password' => bcrypt('shangrila2024$'),
            'api_token' => Str::random(80)
        ]);
    }
}
