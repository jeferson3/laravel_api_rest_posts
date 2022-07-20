<?php

namespace App\Repositories\Customer\Post;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function getAll(array $request): array;
    public function comment(array $request, Post $post): Post|null;
    public function like(array $request, Post $post): Post|null;
}
