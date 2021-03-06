<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        URL::forceRootUrl(config('app.url'));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

//        $this->mapWebRoutes();
    }

//    /**
//     * Define the "web" routes for the application.
//     *
//     * These routes all receive session state, CSRF protection, etc.
//     *
//     * @return void
//     */
    protected function mapWebRoutes()
    {
        Route::prefix(config('haakco.api_path', 'api/v1') . '/web')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.auth.admin.user.php'));

        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.auth.file.php'));

        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.auth.rights.php'));

        // Uptime Test endpoints
        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.auth.uptime_test.php'));

        // Users endpoints
        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.auth.user.php'));

        // These routes should never be hit. Used to work around laravel
        Route::prefix('/')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.fake.php'));

        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.file.php'));

        Route::prefix(config('haakco.api_path', 'api/v1'))
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
