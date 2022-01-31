<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Dzyfhuba\PostSys\Models\Comment;
use Dzyfhuba\PostSys\Models\Post;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' =>  factory(Post::class)->create()->id
    ];
});
