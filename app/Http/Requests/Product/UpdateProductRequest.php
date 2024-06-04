<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     title="UpdateProductRequest",
 *     description="Request body for updating an existing product",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The updated title of the product",
 *         example="Updated Product Title"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="The updated price of the product",
 *         example=39.99
 *     ),
 *     @OA\Property(
 *         property="stock_quantity",
 *         type="integer",
 *         description="The updated stock quantity of the product",
 *         example=150
 *     ),
 *     @OA\Property(
 *         property="summary",
 *         type="string",
 *         description="The updated summary of the product",
 *         example="Updated product summary"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The updated description of the product",
 *         example="Updated product description"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="The updated ID of the category associated with the product",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="feature_image_url",
 *         type="string",
 *         description="The updated feature image URL of the product",
 *         example="https://example.com/updated_image.jpg"
 *     )
 * )
 */

class UpdateProductRequest extends FormRequest
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
