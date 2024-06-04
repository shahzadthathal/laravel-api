<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Interfaces\IPost;
use App\Interfaces\ICategory;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Classes\ApiResponseClass;



class PostController extends Controller
{
    
    private IPost $postRepo;
    private ICategory $categoryRepo;
    
    public function __construct(IPost $iPost, ICategory $iCategory)
    {
        $this->postRepo = $iPost;
        $this->categoryRepo = $iCategory;
    }

    
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     operationId="getPostsList",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Returns list of posts",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index()
    {
        $data = $this->postRepo->index();

        return ApiResponseClass::sendResponse(PostResource::collection($data),'',200);
    }

    
    /**
     * @OA\Post(
     *     path="/api/posts",
     *     operationId="storePost",
     *     tags={"Posts"},
     *     summary="Store a new post",
     *     description="Create a new post",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePostRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(StorePostRequest $request)
    {
        if(!$this->categoryRepo->exists($request->category_id)){
            return ApiResponseClass::throw('','Category not exists');
        }

        $details =[
            'title' => $request->input('title'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
            'feature_image_url' => $request->input('feature_image_url'),
            'description' => $request->input('description'),
        ];
        
        DB::beginTransaction();
        try{
             $model = $this->postRepo->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new PostResource($model),'Post Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     operationId="getPostById",
     *     tags={"Posts"},
     *     summary="Get a specific post by ID",
     *     description="Returns a single post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show($id)
    {
        $model = $this->postRepo->getById($id);

        return ApiResponseClass::sendResponse(new PostResource($model),'',200);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     summary="Update an existing post",
     *     description="Updates a post and returns the updated post",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "status", "category_id", "feature_image_url", "description"},
     *             @OA\Property(property="title", type="string", example="Updated Post Title"),
     *             @OA\Property(property="status", type="integer", example="1"),
     *             @OA\Property(property="category_id", type="integer", example="1"),
     *             @OA\Property(property="feature_image_url", type="string", example="http://example.com/image.jpg"),
     *             @OA\Property(property="description", type="string", example="Updated description of the post.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, $id)
    {
        if(!$this->categoryRepo->exists($request->category_id)){
            return ApiResponseClass::throw('','Category not exists');
        }
        
        $updateDetails =[
            'title' => $request->input('title'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
            'feature_image_url' => $request->input('feature_image_url'),
            'description' => $request->input('description'),
        ];
        
        DB::beginTransaction();
        try{
             $model = $this->postRepo->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Post Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     summary="Delete an existing post",
     *     description="Deletes a post and returns a success message",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Post Delete Successful"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function destroy($id)
    {
         $this->postRepo->delete($id);

        return ApiResponseClass::sendResponse('Post Delete Successful','',204);
    }
}