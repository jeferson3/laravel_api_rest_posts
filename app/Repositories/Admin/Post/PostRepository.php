<?php

namespace App\Repositories\Admin\Post;

use App\Models\Post;

final class PostRepository implements PostRepositoryInterface
{
    /**
     * Table model
     * @var Post
     */
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get all paginated data from database
     * @param array $request
     * @return array
     */
    public function getAll(array $request): array
    {
        $limit = isset($request['limit']) ? $request['limit'] : 10;
        $page  = isset($request['page'])  ? $request['page'] : 1;

        $where = " 1=1 ";
        $bind  = array();
        if (isset($request['search'])) {
            $where .= " AND (title like CONCAT('%', ?, '%') || description like CONCAT('%', ?, '%'))";
            $bind = array($request['search'], $request['search']);
        }

        return [
            'data'      => auth()->user()->Posts()->whereRaw($where, $bind)->orderBy('id', 'desc')->limit($limit)->offset(($page - 1) * $limit)->get(),
            'total'     => auth()->user()->Posts()->whereRaw($where, $bind)->count(),
            'page'      => $page,
            'per_page'  => $limit
        ];
    }

    /**
     * Save new record in database
     * @param array $request
     * @return Post|null
     */
    public function create(array $request): Post|null
    {
        return $this->post->create([
            'title'        => $request['title'],
            'description'  => $request['description'],
            'user_id'      => auth()->user()->id
        ]);
    }

    /**
     * Update record from database
     * @param Post $post
     * @param array $request
     * @return Post|null
     */
    public function update(Post $post, array $request): Post|null
    {
        $post->update([
            'title'        => $request['title'],
            'description'  => $request['description'],
        ]);
        return $post;
    }

    /**
     * Delete record from database
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
