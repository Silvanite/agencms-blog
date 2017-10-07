<?php

namespace Silvanite\AgencmsBlog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use Silvanite\AgencmsBlog\BlogCategory;
use Silvanite\Agencms\Traits\HasRepeaterFields;
use Silvanite\Agencms\Traits\HasImages;
use App\User;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class BlogArticle extends Model implements hasMedia
{
    use HasMediaTrait, HasRepeaterFields, HasImages;

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
        'author'
    ];

    protected $appends = [
        'categories'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    protected $dates = [
        'published',
        'expires'
    ];

    public $images = [
        'featuredimage'
    ];

    /**
     * Declare the names of the content repeaters for processing
     *
     * @var array
     */
    public $repeaters = [
        'content'
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
}
