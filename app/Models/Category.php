<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The category ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The category name"
 *     ),
 * )
 */

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public $timestamps = false;

    public function categorizable()
    {
        return $this->morphTo();
    }
    
}
