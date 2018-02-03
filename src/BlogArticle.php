<?php

namespace Silvanite\AgencmsBlog;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Silvanite\AgencmsBlog\BlogCategory;

class BlogArticle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'title',
        'preview_title',
        'description',
        'content',
        'active',
        'published',
        'expires',
        'meta_title',
        'meta_description',
        'author',
        'featuredimage',
        'tags',
    ];

    protected $appends = [
        'categories',
    ];

    protected $casts = [
        'content' => 'array',
        'tags' => 'array',
    ];

    protected $dates = [
        'published',
        'expires',
    ];

    /**
     * Get all categories this article is assigned to
     *
     * @return Illuminate\Support\Collection
     */
    public function attachedCategories()
    {
        return $this->belongsToMany(BlogCategory::class);
    }

    /**
     * Get the author of this raticle
     *
     * @return Illuminate\Support\Collection
     */
    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function getCategoriesAttribute()
    {
        return $this->attachedCategories->pluck(['id']);
    }

    /**
     * Returns an array of dinstict tags used across all entries
     *
     * @return array
     */
    public static function uniqueTags()
    {
        return self::get(['tags'])->pluck('tags')->collapse()->unique()->sort()->all();
    }
}
