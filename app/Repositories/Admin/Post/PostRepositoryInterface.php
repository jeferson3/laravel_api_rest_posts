<?php

namespace App\Repositories\Admin\Post;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function getAll(array $request): array;
    public function create(array $request): Post|null;
    public function update(Post $post, array $request): Post|null;
    public function delete(Post $post): bool;
}
