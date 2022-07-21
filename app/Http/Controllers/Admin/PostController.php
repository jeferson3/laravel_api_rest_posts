<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestValidation;
use App\Http\Resources\FailResponseResource;
use App\Http\Resources\PaginationResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Post;
use App\Repositories\Admin\Post\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Exchange Rate - return data of database
     *
     * @OA\Get (
     *     path="/admin/posts",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="404", description="Response with error"),
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
     *          name="coin",
     *          in="query",
     *          required=false,
     *          description="filter - coin name",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index(Request $request)
    {
        return (new PaginationResponseResource($this->postRepository->getAll($request->toArray())))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Exchange Rate - Store a newly created resource in storage.
     *
     * @OA\Post (
     *     path="/admin/posts",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
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
     *                  required={"coin", "value"},
     *                  @OA\Property(property="coin", type="string" , example="dollar"),
     *                  @OA\Property(property="value", type="float" , example="10.5"),
     *              )
     *          )
     *      )
     *
     *    )
     *
     *
     * @param RequestValidation $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(RequestValidation $request)
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
     *     path="/admin/posts/{exchange_rate}",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
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
     *                  required={"coin", "value"},
     *                  @OA\Property(property="coin", type="string" , example="dollar"),
     *                  @OA\Property(property="value", type="float" , example="10.5"),
     *              )
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="exchange_rate",
     *          in="path",
     *          required=true,
     *          description="exchange rate ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     * @param RequestValidation $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(RequestValidation $request, Post $post)
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
     *     path="/admin/posts/{exchange_rate}",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="404", description="Response with error"),
     *     tags={"Admin-Post"},
     *     security={{ "jwt": {} }},
     *
     *     @OA\Parameter(
     *          name="exchange_rate",
     *          in="path",
     *          required=true,
     *          description="exchange rate ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *    )
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function destroy(Post $post)
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
