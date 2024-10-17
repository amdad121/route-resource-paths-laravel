<?php

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\ServiceProvider;

class RouteResourcesPathsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Use the custom resource registrar instead of the default one
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', PathsResourceRegistrar::class);

        // Add the macro to PendingResourceRegistration to handle custom paths
        PendingResourceRegistration::macro('paths', function (array $paths) {
            $this->options['paths'] = $paths;

            return $this;
        });
    }
}
