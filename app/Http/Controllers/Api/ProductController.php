<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Interfaces\IProduct;
use App\Interfaces\ICategory;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Classes\ApiResponseClass;



class ProductController extends Controller
{
    
    private IProduct $productRepo;
    private ICategory $categoryRepo;
    
    public function __construct(IProduct $iProduct, ICategory $iCategory)
    {
        $this->productRepo = $iProduct;
        $this->categoryRepo = $iCategory;
    }
    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="getProductsList",
     *     tags={"Products"},
     *     summary="Get list of products",
     *     description="Returns list of products",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
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
        $data = $this->productRepo->index();

        return ApiResponseClass::sendResponse(ProductResource::collection($data),'',200);
    }


    /**
     * @OA\Post(
     *     path="/api/products",
     *     operationId="storeProduct",
     *     tags={"Products"},
     *     summary="Store a new product",
     *     description="Create a new product",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {

        if(!$this->categoryRepo->exists($request->category_id)){
            return ApiResponseClass::throw('','Category not exists');
        }
        
        $details = [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'stock_quantity' => $request->input('stock_quantity'),
            'summary' => $request->input('summary'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'feature_image_url' => $request->input('feature_image_url'),
        ];

       
        DB::beginTransaction();
        try{
            $model = $this->productRepo->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($model),'Product Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     summary="Get a specific product by ID",
     *     description="Returns a single product",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of product to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function show($id)
    {
        $model = $this->productRepo->getById($id);

        return ApiResponseClass::sendResponse(new ProductResource($model),'',200);
    }

   
    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Update an existing product",
     *     description="Updates a product and returns the updated product",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of product to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "price", "stock_quantity", "summary", "description", "category_id", "feature_image_url"},
     *             @OA\Property(property="title", type="string", example="Updated Product Title"),
     *             @OA\Property(property="price", type="number", format="float", example=10.5),
     *             @OA\Property(property="stock_quantity", type="integer", example=100),
     *             @OA\Property(property="summary", type="string", example="Updated summary of the product."),
     *             @OA\Property(property="description", type="string", example="Updated description of the product."),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="feature_image_url", type="string", format="uri", example="http://example.com/image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, $id)
    {
        if(!$this->categoryRepo->exists($request->category_id)){
            return ApiResponseClass::throw('','Category not exists');
        }

        $updateDetails = [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'stock_quantity' => $request->input('stock_quantity'),
            'summary' => $request->input('summary'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'feature_image_url' => $request->input('feature_image_url'),
        ];
        
        DB::beginTransaction();
        try{
            $model = $this->productRepo->update($updateDetails,$id);

            DB::commit();
            return ApiResponseClass::sendResponse('Product Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     summary="Delete an existing product",
     *     description="Deletes a product and returns a success message",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Product Delete Successful"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->productRepo->delete($id);

        return ApiResponseClass::sendResponse('Product Delete Successful','',204);
    }

}