<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


/**
 * @OA\Schema(
 *     schema="StorePostRequest",
 *     type="object",
 *     title="Store Post Request",
 *     required={"title", "description"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the post",
 *         example="Example Post Title"
 *     ),
 *     @OA\Property(
 *         property="feature_image_url",
 *         type="string",
 *         description="URL of the feature image",
 *         example="http://example.com/feature-image.jpg"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="integer",
 *         description="Status of the post",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="The category ID associated with the post",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the post",
 *         example="This is an example description of the post."
 *     )
 * )
 */



class StorePostRequest extends FormRequest
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
            'feature_image_url' => 'nullable',
            'status' => 'required',
            'category_id' => 'required',
            'description' => 'required',
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
