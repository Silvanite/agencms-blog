<?php

namespace Silvanite\AgencmsBlog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use BlogArticle;

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
