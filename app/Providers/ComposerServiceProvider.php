<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer(
            'admin-panel.base.header',
            'App\Http\ViewComposers\WebsiteComposer'
        );
        view()->composer(
            'admin-panel.base.sidemenu',
            'App\Http\ViewComposers\PermissionComposer'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
