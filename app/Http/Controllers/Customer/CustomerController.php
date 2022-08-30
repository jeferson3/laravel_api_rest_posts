<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\PostCommentRequest;
use App\Http\Resources\PaginationResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Jobs\CommentJob;
use App\Jobs\LikeJob;
use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Posts - return posts of database
     *
     * @OA\Get (
     *     path="/posts",
     *     summary="CustomerController",
     *     @OA\Response(response="200", description="Response with success"),
     *
     *     tags={"Customer-Post"},
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
        return (new PaginationResponseResource($this->postRepository->getMyPosts($request->toArray())))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Post - Store a newly created resource in storage.
     *
     * @OA\Post (
     *     path="/posts/{post}/comments",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     @OA\Response(response="404", description="Response with error"),
     *     tags={"Customer-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"comment"},
     *                  @OA\Property(property="comment", type="string" , example="teste comment")
     *              )
     *          )
     *      ),
     *
     *     @OA\Parameter(
     *          name="post",
     *          in="path",
     *          required=true,
     *          description="Post id",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *
     *    )
     *
     *
     * @param PostCommentRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function comment(PostCommentRequest $request, Post $post): JsonResponse
    {
        CommentJob::dispatchAfterResponse($post, $this->postRepository);
        return (new SuccessResponseResource(true))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Post - Store a newly created resource in storage.
     *
     * @OA\Post (
     *     path="/posts/{post}/likes",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     @OA\Response(response="404", description="Response with error"),
     *     tags={"Customer-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\Parameter(
     *          name="post",
     *          in="path",
     *          required=true,
     *          description="Post id",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *
     *    )
     *
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function like(Request $request, Post $post): JsonResponse
    {
        LikeJob::dispatchAfterResponse($post, $this->postRepository);
        return (new SuccessResponseResource(true))
            ->response()
            ->setStatusCode(200);
    }

}
