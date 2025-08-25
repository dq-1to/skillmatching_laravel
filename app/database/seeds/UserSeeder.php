<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者ユーザー
        factory(App\User::class)->create([
            'name'  => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role'  => 1, // 管理者
        ]);

        // 一般ユーザー
        factory(App\User::class, 5)->create();
    }
}
