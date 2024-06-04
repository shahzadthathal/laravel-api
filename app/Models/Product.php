<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     description="Product model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the product",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the product",
 *         example="Product Title"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="The slug of the product",
 *         example="product-title"
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
 *         property="feature_image_url",
 *         type="string",
 *         description="The feature image URL of the product",
 *         example="https://example.com/image.jpg"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="integer",
 *         description="The status of the product",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="The ID of the category associated with the product",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="category_type",
 *         type="string",
 *         description="The type of the category associated with the product",
 *         example="App\Models\Category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the product",
 *         example="Product description"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the product was created",
 *         example="2024-06-07 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the product was last updated",
 *         example="2024-06-07 12:00:00"
 *     )
 * )
 */

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'price',
        'stock_quantity',
        'summary',
        'description',
        'category_id',
        'category_type',
        'feature_image_url',
        // Add other fillable attributes here if needed
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the product's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
