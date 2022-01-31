# Post System Laravel

>Features:  
> - Post
> - Comment
> - Reply
> - Like




* [Installation](#installation)
* [Usage](#usage)
* [Blade](#blade)
* [Advance Eloquent Model](#advance-eloquent-model)
* [Example](#example)

> :warning: Laravel 6+

## Installation
Use the composer require or add to composer.json. 
```bash
composer require dzyfhuba/laravel-post-system

```

If you are using SQL database server to store log events you would need to run the migrations first. The MongoDB driver does not require the migration.
```bash
php artisan migrate
```

## Usage
Since this is a custom package, and your Model should have User and database users table.

### Basic Usage
First, add the ***use Dzyfhuba\PostSys\Traits\HasPost*** trait to your User model:

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Dzyfhuba\PostSys\Traits\HasPost;

class User extends Authenticatable
{
    use HasPost;

    // ...
}

```

### User
```php
// Fetch the User
$user = User::find(1);

// get User Posts
$posts =  $user->posts;
// get latest Posts
$latestPosts =  $user->latest_posts;

// get Active Posts
$activePosts =  $user->active_posts;

// get Active Posts
$inactivePosts =  $user->inactive_posts;

// Post Count
$postsCount =  $user->posts_count;
// Active Post Count
$activePostsCount =  $user->active_posts_count;
// Inactive Post Count
$inactivePostsCount =  $user->inactive_posts_count;

/**
 * Assgin or remove Post
 * Create or fetch the Post
**/

use Dzyfhuba\PostSys\Models\Post;
//Get the single Post or Post::find(1); 
$post = Post::create([
        'title'=> 'My First Post',
        'description'=> 'This package will create posts, comments, likes, diskies and replies',
        'status'=> 1, // default active(1) for inactive(0)
    ]); 

//Assign single Post
$user->assignPost($post);
//Assign multiple Post 
$user->assignPost([$post, $post2]);

//Remove single Post
$user->removePost($post);
//Remove multiple Post 
$user->removePost([$post, $post2]);

//Synchronize single Post
$user->syncPosts($post);
//Synchronize multiple Post 
$user->syncPosts([$post, $post2]);

```
### Posts
```php
use Dzyfhuba\PostSys\Models\Post;
/**
 * Get all Posts
 * @return Array|Posts|Comments|Replies 
 * Response all Posts with their comments and replies on each comment
**/
$posts = Post::all();

/**
 * Fetch a single Post
 * @return Object|Posts, Array|Comments|Replies 
 * Response Post with all comments and replies on each comment
**/
$post = Post::find(1);

// Create new Post
$post = Post::create([
        'title'=> 'My First Post',
        'description'=> 'This package will create posts, comments, likes, diskies and replies',
        'status'=> 1, // default active(1) for inactive(0)
    ]); 

// Update Post
$post->update(['title'=>'new text1']); // Boolean 

/**
 * Delete Post
 * @return Boolean
 * This will delete the Post as well as all comments & replies of that Post
**/
$post->delete();

//Assign a Post to user
$post->user()->associate($user)->save();

//Remove a Post
$post->user()->dissociate()->save();

// First and Last Post for the User
$post = $user->posts->first();
$post = $user->posts->last();

```

### Comments
```php

/**
 * Get all Comments for the Post
 * @return Array|Comments|Replies 
 * Response all comments and replies for the Post
**/

$comments = $post->comments;

/**
 * Add Comment to Post
 * 	@return Object|Comment with replies[]
**/
$comment = $post->addComment("My First Comment", $user);

/**
 * Add Comment to Post
 * @return Array|Comments|replies
 * Response all comments added to the post
**/
$comments = $post->addAllComments("This is awesome package", $user);

/**
 * Edit Comment to Post
 * @return Object|Comment with Array|replies
 * Response edited comment with replies
**/
$comment = $comment->editComment("My Edit Comment" , $OptionalParamsStatus =1);

/**
 * Delete Comment
 * @return Boolean
 * This will delete the Comment as well as all replies of that Comment
**/
$comment->delete();

// First and Last Comment for the Post
$comment = $post->comments->first();
$comment = $post->comments->last();

/**
 * Fetching a single comment 
 * Get comment details
**/
use Dzyfhuba\PostSys\Models\Comment;

$comment = Comment::find(1); // OR $post->addComment("My First Comment", $user);

$commentText = $comment->content; //comment content
$commentDate =  $comment->created_at; //comment created date
$commentUpdate = $comment->updated_at; //comment updated date
$commentedByUser = $comment->user; // commented user in Object

```

### Replies
```php

/**
 * Get all Replies for the Comment
 * @return Array|Replies 
 * Response all Replies for the Comment
**/

$replies = $comment->replies;

/**
 * Add Reply to Comment
 * 	@return Object|Reply
**/
$reply = $comment->addReply("My First Reply", $user);

/**
 * Add Reply to Comment
 * @return Array|Replies
 * Response all Replies added to the comment
**/
$replies = $comment->addAllReplies("This is awesome package, I like reply feature.", $user);

/**
 * Edit Reply to Comment
 * @return Object|Reply
 * Response edited reply
**/
$reply = $reply->editReply("My Edit Reply" , $OptionalParamsStatus =1);

/**
 * Delete Reply
 * @return Boolean
 * This will delete the Reply
**/
$reply->delete();

// First and Last Reply for the Comment
$reply = $comment->replies->first();
$reply = $comment->replies->last();

/**
 * Fetching a single reply 
 * Get reply details
**/
use Dzyfhuba\PostSys\Models\Reply;

$reply = Reply::find(1); // OR $comment->addReply("My First Reply", $user);

$replyText = $reply->content; //reply content
$replyDate =  $reply->created_at; //reply created date
$replyUpdate = $reply->updated_at; //reply updated date
$repliedByUser = $reply->user; // replied user in Object

```

## Blade
Can also use in laravel blade file.

```php

@foreach ($posts as $post)
  <div>
    <h3>Post Id : {{ $post->id }}</h3>
    <p>Post title : {{ $post->title }}</p>
    <p>Post description : {{ $post->description }}</p>
    <p>Post status : {{ $post->status }}</p>
    <p>Post created date : {{ $post->created_at }}</p>
    <p>Post created by User : {{ $post->user->name }}</p>
    <p>Comments on Post: 
      @foreach ($post->comments as $comment)
        <ul>
          <li>Comment : {{ $comment->content }}</li>
          <li>Comment created date: {{ $comment->created_at }}</li>
          <li>Comment created by User: {{ $comment->user->name }}</li>
          <li>Reply on comment :
            @foreach ($comment->replies as $reply)
              <ul>
                <li>Reply : {{ $reply->content }}</li>
                <li>Reply created date: {{ $reply->created_at }}</li>
                <li>Reply created by User: {{ $reply->user->name }}</li>
              </ul>
            @endforeach
          </li>
        </ul>
      @endforeach
    </p>
  </div>
@endforeach

```
## Advance Eloquent Model
Used with & withCount

```php

use Dzyfhuba\PostSys\Models\Post;

$posts = Post::with('user')->where('user_id', 1)->first();
$user = User::with(['posts', 'active_posts',  'inactive_posts', 'latest_posts'])->withCount(['posts', 'active_posts', 'inactive_posts'])->get();

```