<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     required={"title", "slug", "status", "category_id", "category_type"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The post ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the post",
 *         example="Example Post Title"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="The slug of the post",
 *         example="example-post-title"
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
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The time the post was created",
 *         example="2024-06-04T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The time the post was last updated",
 *         example="2024-06-04T00:00:00Z"
 *     )
 * )
 */


class Post extends Model
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
        'feature_image_url',
        'status',
        'category_id',
        'category_type',
        'description',
        // Add other fillable attributes here if needed
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
