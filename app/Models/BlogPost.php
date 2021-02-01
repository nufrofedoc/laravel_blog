<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BlogPost
 *
 * @package App\Models
 *
 * @property \App\Models\BlogCategory $category
 * @property \App\Models\User         $user
 * @property string                   $title
 * @property string                   $slug
 * @property string                   $content_html
 * @property string                   $content_raw
 * @property string                   $excerpt
 * @property string                   $pubslihed_at
 * @property boolean                  $is_published
 */

class BlogPost extends Model
{
    use SoftDeletes;
    use HasFactory;

    const UNKNOWN_USER = 1;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'is_published',
        'published_at',
    ];

    /**
     * Article category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        // Article belongs to category
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Author of an article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // Article belongs to user
        return $this->belongsTo(User::class);
    }
}
