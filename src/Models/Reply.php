<?php

namespace Dzyfhuba\PostSys\Models;

use Dzyfhuba\PostSys\Models\Comment;
use Dzyfhuba\PostSys\Models\Message;
use Dzyfhuba\PostSys\Traits\HasReply;
use Dzyfhuba\PostSys\Objects\Message as MessageObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Reply extends MessageObject
{
    use HasReply;
    
    protected $guarded = [];
    public $timestamps = false;

    protected $with = ['message'];

    /**
     * Get all of the message for the reply.
     */
    public function message(): MorphOne
    {
        return $this->morphOne(Message::class, 'messageable');
    }

    /**
	 * Get the comment of the reply.
	 */
	public function comment(): BelongsTo
	{
	    return $this->belongsTo(Comment::class);
	}
}
