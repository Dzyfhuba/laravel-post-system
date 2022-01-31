<?php

namespace Dzyfhuba\PostSys\Models;

use Dzyfhuba\PostSys\Models\Post;
use Dzyfhuba\PostSys\Models\Reply;
use Dzyfhuba\PostSys\Models\Message;
use Dzyfhuba\PostSys\Traits\HasComment;
use Dzyfhuba\PostSys\Objects\Message as MessageObject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Comment extends MessageObject
{
    use HasComment;
    
    protected $guarded = [];
    public $timestamps = false;

    protected $with = ['replies'];
    
    /**
     * Get all of the message for the comment.
     */
    public function message(): MorphOne
    {
        return $this->morphOne(Message::class, 'messageable');
    }

    /**
	 * Get the post of the comment.
	 */
	public function post(): BelongsTo
	{
	    return $this->belongsTo(Post::class);
	}

	/**
	 * Get all of the replies for the comment.
	 */
	public function replies(): HasMany
	{
	    return $this->hasMany(Reply::class);
	}

}
