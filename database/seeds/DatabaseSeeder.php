<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'Phyo Htet Aung',
            'email' => 'scm.phyohtetaung@gmail.com',
            'password' => Hash::make('123123123'),
            'type' => 0,
            'profile' => 'default.jpg',
            'profile_path' => env('APP_URL').'/images/'.'default.jpg',
            'create_user_id' => 1,
            'updated_user_id' => 1,
            'deleted_user_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);
    }
}