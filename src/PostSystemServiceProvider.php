<?php

namespace Dzyfhuba\PostSys;

use Illuminate\Support\ServiceProvider;
use Dzyfhuba\PostSys\Models\Reply;
use Dzyfhuba\PostSys\Models\Comment;
use Illuminate\Database\Eloquent\Relations\Relation;

class PostSystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([ 'Comments' => Comment::class,  'Replies' => Reply::class ]);
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
    }
}
