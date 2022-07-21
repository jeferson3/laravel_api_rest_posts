<?php

namespace App\Jobs;

use App\Http\Resources\FailResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Post;
use App\Repositories\Customer\Post\PostRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * @var Post
     */
    private Post $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, PostRepository $postRepository)
    {
        $this->post = $post;
        $this->postRepository = $postRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->postRepository->like(\request()->all(), $this->post);
    }
}
