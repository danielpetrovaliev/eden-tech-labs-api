<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $postCreationDate = $faker->dateTime();

    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'author_name' => $faker->name,
        'author_email' => $faker->email,
        'created_at' => $postCreationDate,
        'updated_at' => $postCreationDate
    ];
});
