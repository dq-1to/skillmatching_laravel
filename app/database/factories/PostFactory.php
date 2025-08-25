<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::query()->inRandomOrder()->value('id') ?? factory(User::class)->create()->id;
        },
        'title'   => $faker->sentence(6),
        'price'   => $faker->numberBetween(500, 8000),
        'content' => $faker->paragraph(4),
        'image'   => null,
        'del_flag' => 0,
    ];
});