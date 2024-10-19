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

        // Add the macro to set global paths for all resource routes
        Route::macro('resourcePaths', function (array $paths) {
            PathsResourceRegistrar::setGlobalPaths($paths);
        });

        // Add the global method to set singleton resource paths
        Route::macro('singletonPaths', function (array $paths) {
            PathsResourceRegistrar::setGlobalSingletonPaths($paths);
        });

        // Add a macro to handle resources registration with global paths
        Route::macro('resources', function (array $resources) {
            $registrations = [];
            foreach ($resources as $name => $controller) {
                $registrations[] = $this->resource($name, $controller);
            }

            // Add a method to apply paths to all resources
            return new class($registrations) {
                protected $registrations;

                public function __construct(array $registrations)
                {
                    $this->registrations = $registrations;
                }

                public function paths(array $paths)
                {
                    foreach ($this->registrations as $registration) {
                        $registration->paths($paths);
                    }
                }
            };
        });
    }
}
