<?php

namespace App\Repositories\Post;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function getAll(array $request): array;
    public function getMyPosts(array $request): array;
    public function create(array $request): Post|null;
    public function update(Post $post, array $request): Post|null;
    public function delete(Post $post): bool;
    public function comment(array $request, Post $post): Post|null;
    public function like(array $request, Post $post): Post|null;
}
