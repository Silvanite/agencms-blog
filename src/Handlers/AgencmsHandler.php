<?php

namespace Agencms\Blog\Handlers;

use Agencms\Core\Route;
use Agencms\Core\Field;
use Agencms\Core\Group;
use Agencms\Core\Option;
use Silvanite\Brandenburg\Policy;
use Agencms\Core\Relationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Agencms\Blog\BlogArticle;
use Agencms\Core\Facades\ConfigFacade as Agencms;

class AgencmsHandler
{
    /**
     * Register all routes and models for the Admin GUI (AUI)
     *
     * @return void
     */
    public static function registerAdmin()
    {
        if (!Gate::allows('admin_access')) return;

        self::registerArticleAdmin();
        self::registerCategoryAdmin();
    }

    /**
     * Register the Agencms endpoints for Blog Article administration
     *
     * @return void
     */
    private static function registerArticleAdmin()
    {
        if (!Gate::allows('blog_articles_read')) return;

        Agencms::registerRoute(
            Route::init('blog_articles', 'Blog Articles', '/agencms/blog/article')
                ->icon('create')
                ->addGroup(
                    Group::large('Details')->addField(
                        Field::string('title', 'Title')->medium()->required()->list()
                            ->maxLength(125)
                            ->link('slug'),
                        Field::string('slug', 'Slug')->medium()->required()->list()
                            ->maxLength(125)
                            ->slug(),
                        Field::string('description', 'Description')
                            ->full()
                            ->multiline()
                            ->required(),
                        Field::string('meta_title', 'Meta Title')
                            ->maxLength(125),
                        Field::string('meta_description', 'Meta Description')
                            ->multiline()
                            ->maxLength(255),
                        Field::related('author', 'Author')->model(
                            Relationship::make('users')
                        ),
                        Field::related('categories', 'Categories')->multiple(10)->model(
                            Relationship::make('blog_category')
                        ),
                        Field::select('tags', 'Tags')->tags()->addOptions(
                            BlogArticle::uniqueTags()
                        )
                    ),
                    Group::small('Attributes')->addField(
                        Field::number('id', 'Id')->readonly()->list(1),
                        Field::boolean('active', 'Active')->list(),
                        Field::date('published', 'Published'),
                        Field::date('expires', 'Expires'),
                        Field::image('featuredimage', 'Featured Image')
                    ),
                    Group::full('Content')->repeater('content')->addGroup(
                        Group::full('Heading')->key('heading')->addField(
                            Field::string('heading', 'Heading')->maxLength(125)
                        ),
                        Group::full('Text')->key('text')->addField(
                            Field::string('text', 'Text')->multiline()
                        ),
                        Group::full('Image')->key('image')->addField(
                            Field::image('image', 'Image')->small()
                        )
                    )
                )
        );
    }

    /**
     * Register the Agencms endpoints for Blog Categories administration
     *
     * @return void
     */
    private static function registerCategoryAdmin()
    {
        if (!Gate::allows('blog_categories_read')) return;

        Agencms::registerRoute(
            Route::init('blog_category', 'Blog Categories', '/agencms/blog/category')
                ->icon('list')
                ->addGroup(
                    Group::small('Attributes')->addField(
                        Field::number('id', 'Id')->readonly()->list(1),
                        Field::boolean('published', 'Published')->list(100),
                        Field::image('featuredimage', 'Featured Image')
                    ),
                    Group::large('Details')->addField(
                        Field::string('name', 'Name')->medium()->required()->list()
                            ->maxLength(50)->minLength(3)
                            ->link('slug'),
                        Field::string('slug', 'Slug')->medium()->required()->list()
                            ->maxLength(50)->minLength(3)
                            ->slug(),
                        Field::string('description', 'Description')->full()->required(),
                        Field::string('meta_title', 'Meta Title')
                            ->maxLength(50),
                        Field::string('meta_description', 'Meta Description')
                            ->maxLength(255)
                    )
                )
        );
    }
}
