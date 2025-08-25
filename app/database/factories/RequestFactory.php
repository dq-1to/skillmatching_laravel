<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobRequest;
use App\User;
use App\Post;
use Faker\Generator as Faker;

$factory->define(JobRequest::class, function (Faker $faker) {
    return [
        'user_id'  => User::query()->inRandomOrder()->value('id')
            ?? factory(User::class)->create()->id,

        'post_id'  => Post::query()->inRandomOrder()->value('id')
            ?? factory(Post::class)->create()->id,

        'content'  => $faker->sentence(10),
        'tel'      => $faker->numerify('0##########'), // 10〜11桁相当の数字
        'email'    => $faker->safeEmail,
        'due_date' => $faker->date('Y-m-d'), // nullableにしたいなら時々 null を返してもOK
        'status'   => 0,
        'del_flag' => 0,
    ];
});
