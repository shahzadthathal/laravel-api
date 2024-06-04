<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ICategory;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Classes\ApiResponseClass;



class CategoryController extends Controller
{
    private ICategory $categoryRepo;

    public function __construct(ICategory $iCategory)
    {
        $this->categoryRepo = $iCategory;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     operationId="getCategoryList",
     *     tags={"Categories"},
     *     summary="Get list of categories",
     *     description="Returns list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function index()
    {
        $data = $this->categoryRepo->index();
        return ApiResponseClass::sendResponse(CategoryResource::collection($data), '', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     operationId="storeCategory",
     *     tags={"Categories"},
     *     summary="Store a new category",
     *     description="Stores a new category",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *    @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $details = ['name' => $request->input('name')];
        DB::beginTransaction();
        try {
            $model = $this->categoryRepo->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new CategoryResource($model), 'Category Create Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     operationId="getCategoryById",
     *     tags={"Categories"},
     *     summary="Get category information",
     *     description="Returns category data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of category to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function show($id)
    {
        $model = $this->categoryRepo->getById($id);
        return ApiResponseClass::sendResponse(new CategoryResource($model), '', 200);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     operationId="updateCategory",
     *     tags={"Categories"},
     *     summary="Update an existing category",
     *     description="Updates a category",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of category to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *    @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $updateDetails = ['name' => $request->name];
        DB::beginTransaction();
        try {
            $model = $this->categoryRepo->update($updateDetails, $id);
            DB::commit();
            return ApiResponseClass::sendResponse('Category Update Successful', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
     *     summary="Delete an existing category",
     *     description="Deletes a category",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of category to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Category deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function destroy($id)
    {
        $this->categoryRepo->delete($id);
        return ApiResponseClass::sendResponse('Category Delete Successful', '', 204);
    }
}
