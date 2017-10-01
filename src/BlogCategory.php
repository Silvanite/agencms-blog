<?php

namespace Silvanite\AgencmsBlog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

use Silvanite\Agencms\Traits\HasImages;

use BlogArticle;

class BlogCategory extends Model implements HasMedia
{
    use HasImages, HasMediaTrait;

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
        'meta_description'
    ];

    protected $images = [
        'featuredimage'
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
