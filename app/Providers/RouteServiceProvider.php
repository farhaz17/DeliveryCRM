<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->AgreedAmountRoute();

        $this->CareerDashboardRoute();
        $this->BikePersonFuel();
        $this->TalabatCodRoute();
        $this->DcRequestRoute();
        $this->mapFourPlRoutes();
        $this->JobsRoute();
        $this->PackagesRoute();

        $this->AccidentRiderRoute();


        //
    }

    protected function AgreedAmountRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/AgreedAmount.php'));
    }

    protected function BikePersonFuel()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/BikePersonFuel.php'));
    }

    protected function CareerDashboardRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/CareerDashboard.php'));
    }


    protected function mapFourPlRoutes()
    {
        Route::prefix('api/four-pl')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/four_pl.php'));
    }
    protected function TalabatCodRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/TalabatCodRoute.php'));
    }

    protected function DcRequestRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/DcRequest.php'));
    }
    protected function JobsRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Jobs.php'));
    }
    protected function PackagesRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/packages.php'));
    }
    protected function AccidentRiderRoute()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/AccidentRider.php'));
    }





    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
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
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
