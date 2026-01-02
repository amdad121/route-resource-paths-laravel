<?php

declare(strict_types=1);

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Routing\PendingSingletonResourceRegistration;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteResourcesPathsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', PathsResourceRegistrar::class);

        PendingResourceRegistration::macro('paths', function (array $paths) {
            $this->options['paths'] = $paths;

            return $this;
        });

        PendingSingletonResourceRegistration::macro('paths', function (array $paths) {
            $this->options['paths'] = $paths;

            return $this;
        });

        Route::macro('resourcePaths', function (array $paths) {
            PathsResourceRegistrar::setGlobalPaths($paths);
        });

        Route::macro('singletonPaths', function (array $paths) {
            PathsResourceRegistrar::setGlobalSingletonPaths($paths);
        });

        Route::macro('resources', function (array $resources) {
            $registrations = [];
            foreach ($resources as $name => $controller) {
                $registrations[] = Route::resource($name, $controller);
            }

            return new class($registrations)
            {
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
