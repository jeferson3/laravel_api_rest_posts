<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Http\Resources\FailResponseResource;
use App\Http\Resources\PaginationResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Post - return data of database
     *
     * @OA\Get (
     *     path="/admin/posts",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     tags={"Admin-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          required=false,
     *          description="pagination - per page",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="pagination - page",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *     @OA\Parameter(
     *          name="search",
     *          in="query",
     *          required=false,
     *          description="filter - title or description",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return (new PaginationResponseResource($this->postRepository->getAll($request->toArray())))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Post - Store a newly created resource in storage.
     *
     * @OA\Post (
     *     path="/admin/posts",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     tags={"Admin-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"title", "description"},
     *                  @OA\Property(property="title", type="string" , example="title"),
     *                  @OA\Property(property="description", type="string" , example="description"),
     *              )
     *          )
     *      )
     *
     *    )
     *
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        if ($status = $this->postRepository->create($request->all())) {
            return (new SuccessResponseResource($status))
                ->response()
                ->setStatusCode(200);
        }
        return (new FailResponseResource($status))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put (
     *     path="/admin/posts/{post}",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     @OA\Response(response="404", description="Response with error"),
     *     tags={"Admin-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"title", "description"},
     *                  @OA\Property(property="title", type="string" , example="title"),
     *                  @OA\Property(property="description", type="string" , example="description"),
     *              )
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          required=true,
     *          description="post ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     * @param PostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        if ($status = $this->postRepository->update($post, $request->all())) {
            return (new SuccessResponseResource($status))
                ->response()
                ->setStatusCode(200);
        }
        return (new FailResponseResource($status))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete (
     *     path="/admin/posts/{post}",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     @OA\Response(response="404", description="Response with error"),
     *     tags={"Admin-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\Parameter(
     *          name="post",
     *          in="path",
     *          required=true,
     *          description="post ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        if ($status = $this->postRepository->delete($post)) {
            return (new SuccessResponseResource($status))
                ->response()
                ->setStatusCode(200);
        }
        return (new FailResponseResource($status))
            ->response()
            ->setStatusCode(400);
    }
}
