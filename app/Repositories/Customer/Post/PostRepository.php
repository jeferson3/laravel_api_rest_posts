<?php

namespace App\Repositories\Customer\Post;

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
            'data'      => $this->post->with('Likes', 'Comments')->whereRaw($where, $bind)->orderBy('id', 'desc')->limit($limit)->offset(($page - 1) * $limit)->get(),
            'total'     => $this->post->whereRaw($where, $bind)->count(),
            'page'      => $page,
            'per_page'  => $limit
        ];
    }

    /**
     * Save new record in database
     * @param array $request
     * @param Post $post
     * @return Post|null
     */
    public function comment(array $request, Post $post): Post|null
    {
        $post->Comments()->attach($request['user_id'], ['comment' => $request['comment']]);
        return $post->loadCount('Comments', 'Likes');
    }

    /**
     * Save new record in database
     * @param array $request
     * @param Post $post
     * @return Post|null
     */
    public function like(array $request, Post $post): Post|null
    {
        $post->Likes()->attach($request['user_id']);
        return $post->loadCount('Comments', 'Likes');
    }

}
