<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Dzyfhuba\PostSys\Models\Comment;
use Dzyfhuba\PostSys\Models\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'comment_id' => factory(Comment::class)->create()->id
    ];
});
