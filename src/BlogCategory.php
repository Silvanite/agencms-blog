<?php

namespace Agencms\Blog;

use Agencms\Blog\BlogArticle;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'published',
        'meta_title',
        'meta_description',
        'featuredimage',
    ];

    /**
     * Get all articles in this category
     *
     * @return Illuminate\Support\Collection
     */
    public function articles()
    {
        return $this->hasMany(BlogArticle::class);
    }
}
