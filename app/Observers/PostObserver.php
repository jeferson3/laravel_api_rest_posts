<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * @param  Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $post->user_id = auth()->user()->id;
    }

}
