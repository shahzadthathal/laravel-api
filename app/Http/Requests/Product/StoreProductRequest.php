<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     title="StoreProductRequest",
 *     description="Request body for storing a new product",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the product",
 *         example="Product Title"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="The price of the product",
 *         example=29.99
 *     ),
 *     @OA\Property(
 *         property="stock_quantity",
 *         type="integer",
 *         description="The stock quantity of the product",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="summary",
 *         type="string",
 *         description="The summary of the product",
 *         example="Product summary"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the product",
 *         example="Product description"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="The ID of the category associated with the product",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="feature_image_url",
 *         type="string",
 *         description="The feature image URL of the product",
 *         example="https://example.com/image.jpg"
 *     )
 * )
 */

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'price' => 'required',
            'stock_quantity' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'feature_image_url' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
