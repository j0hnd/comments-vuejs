<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::truncate();

        $faker = Faker::create();

        for ($count = 0; $count <= 5; $count++) {
			$user = \App\User::create([
				'name' => $faker->firstName()
			]);

			$user->save();
		}

    }
}
