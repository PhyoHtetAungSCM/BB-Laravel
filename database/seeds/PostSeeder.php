<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Post');
        for($i = 1 ; $i <= 10 ; $i++){
            DB::table('posts')->insert([
                'title' => $faker->userName,
                'description' => $faker->sentence(),
                'status' => 1,
                'create_user_id' => 1,
                'updated_user_id' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'Updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
