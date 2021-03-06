<?php

namespace Dzyfhuba\PostSys\Models;

use App\Models\User;
use Dzyfhuba\PostSys\Models\Reply;
use Dzyfhuba\PostSys\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
	
    protected $guarded = [];
    protected $with = ['user'];
    //protected $hidden = ['id', 'user_id', 'messageable_type','messageable_id'];

    /**
     * Get all of the comments that are assigned this message.
     */

    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
	 * Get the commentor of the post.
	 */
	public function user(): BelongsTo
	{
	    return $this->belongsTo(User::class);
	}
}
