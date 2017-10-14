<?php

namespace Silvanite\AgencmsBlog\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;
use Route;
use Silvanite\Agencms\Facades\ConfigFacade as Agencms;

use Silvanite\Brandenburg\Policy;
use Silvanite\Brandenburg\Permission;

use Silvanite\AgencmsBlog\Middleware\AgencmsConfig;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->publishes([
            __DIR__.'/../Config/agencms-blog.php' => config_path('agencms-blog.php'),
        ]);

        $this->registerApiRoutes();

        $this->registerAgencms($router);
    }

    /**
     * Register router middleware as plugin for Agencms. This will include all
     * blog functionality in the CMS.
     *
     * @param Router $router
     * @return void
     */
    private function registerAgencms(Router $router)
    {
        $router->aliasMiddleware('agencms.blog', AgencmsConfig::class);
        Agencms::registerPlugin('agencms.blog');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/agencms-blog.php', 'agencms-blog'
        );

        $this->registerPermissions();
    }

    /**
     * Load Api Routes into the application
     *
     * @return void
     */
    private function registerApiRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    /**
     * Register default package related permissions
     *
     * @return void
     */
    private function registerPermissions()
    {
        collect([
            'blog_articles_read', 
            'blog_articles_update', 
            'blog_articles_create', 
            'blog_articles_delete',
            'blog_categories_read', 
            'blog_categories_update', 
            'blog_categories_create', 
            'blog_categories_delete'
        ])->map(function($permission) {
            Gate::define($permission, function ($user) use ($permission) {
                if ($this->nobodyHasAccess($permission)) return true;

                return $user->hasRoleWithPermission($permission);
            });
        });
    }

    /**
     * If nobody has this permission, grant access to everyone
     * This avoids you from being locked out of your application
     *
     * @param string $permission
     * @return boolean
     */
    private function nobodyHasAccess($permission)
    {
        if (!$requestedPermission = Permission::find($permission)) return true;

        return !$requestedPermission->hasUsers();
    }
}
