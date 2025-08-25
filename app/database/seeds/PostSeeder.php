<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App\User::count() === 0) {
            $this->call(UserSeeder::class);
        }

        factory(App\Post::class, 20)->create();
    }
}
