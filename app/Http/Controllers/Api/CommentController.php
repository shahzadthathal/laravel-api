<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\IComment;
use App\Interfaces\IPost;
use App\Interfaces\IProduct;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Product;
use App\Models\Comment;
use App\Classes\ApiResponseClass;



class CommentController extends Controller
{

    private IComment $commentRepo;
    private IPost $postRepo;
    private IProduct $productRepo;

    public function __construct(IComment $iComment, IPost $iPost, IProduct $iProduct)
    {
        $this->commentRepo = $iComment;
        $this->postRepo = $iPost;
        $this->productRepo = $iProduct;
    }

    /**
     * @OA\Post(
     *     path="/api/posts/{postId}/comments",
     *     operationId="storeCommentForPost",
     *     tags={"Comments"},
     *     summary="Store a new comment for a post",
     *     description="Stores a new comment for a post",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         description="ID of the post to add a comment to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"body"},
     *             @OA\Property(property="body", type="string", example="This is a comment on a post.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Comment added successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *    @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function StoreCommentForPost(StoreCommentRequest $request, $postId)
    {
        if(!$this->postRepo->exists($postId)){
            return ApiResponseClass::throw('','Post not exists');
        }
        $details = [
                    'body' => $request->input('body'),
                    'user_id' => Auth::id(), // Get the authenticated user ID
                    'commentable_id' => $postId,
                    'commentable_type' => 'App\Models\Post'
                ];
        DB::beginTransaction();
        try {
            $model = $this->commentRepo->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new CommentResource($model), 'Comment saved successful', 201);
        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }

     /**
     * @OA\Post(
     *     path="/api/products/{productId}/comments",
     *     operationId="storeCommentForProduct",
     *     tags={"Comments"},
     *     summary="Store a new comment for a product",
     *     description="Stores a new comment for a product",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product to add a comment to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"body"},
     *             @OA\Property(property="body", type="string", example="This is a comment on a product.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Comment added successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *    @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function StoreCommentForProduct(StoreCommentRequest $request, $productId)
    {
        if(!$this->productRepo->exists($productId)){
            return ApiResponseClass::throw('','Product not exists');
        }
        $details = [
                    'body' => $request->input('body'),
                    'user_id' => Auth::id(), // Get the authenticated user ID
                    'commentable_id' => $productId,
                    'commentable_type' => 'App\Models\Product'
                ];
        DB::beginTransaction();
        try {
            $model = $this->commentRepo->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new CommentResource($model), 'Comment saved successful', 201);
        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }
}
