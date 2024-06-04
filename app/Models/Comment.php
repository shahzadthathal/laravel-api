<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Comment",
 *     type="object",
 *     title="Comment",
 *     required={"body"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The Comment ID"
 *     ),
 *     @OA\Property(
 *         property="body",
 *         type="string",
 *         description="The comment body"
 *     ),
 *      @OA\Property(
 *         property="commentable_id",
 *         type="integer",
 *         description="The commentable_id associated with the comment i.e. post_id or product_id",
 *         example=1
 *     ),
 *      @OA\Property(
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

class Comment extends Model
{
    use HasFactory;

    // Specify fillable fields
    protected $fillable = ['body', 'commentable_id', 'commentable_type', 'user_id'];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
