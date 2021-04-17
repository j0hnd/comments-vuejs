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
    	\App\PostComments::truncate();
        \App\Posts::truncate();
        \App\Comments::truncate();

        $faker = Faker::create();

        $users = \App\User::all()->pluck('id');

        for ($count = 0; $count <= 5; $count++) {
        	$data = [
        		'user_id' => $users->random(1)[0],
				'title' => $faker->text(45),
				'post' => $faker->paragraph()
			];

			$post = \App\Posts::create($data);

			if ($post->save()) {
				$data = null;
			}
		}
    }
}
