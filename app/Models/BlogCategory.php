<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    /**
     * ID Root
     */
    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    /**
     * Get a parent category
     *
     * @return BlogCategory
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Root'
                : '???');

        return $title;
    }

    /**
     * Check if current object is root
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }

    /**
     * Accessor
     *
     * @param string $valueFromDB
     *
     * @return mixed
     */
    // public function getTitleAttribute($valueFromObject)
    // {
    //     return mb_strtoupper($valueFromObject);
    // }

    /**
     * Mutator
     *
     * @param string $incomingValue
     */
    // public function setTitleAttribute($incomingValue)
    // {
    //     $this->attributes['title'] = mb_strtolower($incomingValue);
    // }
}
