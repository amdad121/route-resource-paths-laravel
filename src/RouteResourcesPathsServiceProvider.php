<?php

declare(strict_types=1);

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Routing\PendingSingletonResourceRegistration;
use Illuminate\Routing\ResourceRegistrar;
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
        $this->app->bind(ResourceRegistrar::class, PathsResourceRegistrar::class);

        PendingResourceRegistration::macro('paths', function (array $paths): object {
            $this->options['paths'] = $paths;

            return $this;
        });

        PendingSingletonResourceRegistration::macro('paths', function (array $paths): object {
            $this->options['paths'] = $paths;

            return $this;
        });

        Route::macro('resourcePaths', function (array $paths): void {
            PathsResourceRegistrar::setGlobalPaths($paths);
        });

        Route::macro('singletonPaths', function (array $paths): void {
            PathsResourceRegistrar::setGlobalSingletonPaths($paths);
        });

        Route::macro('resources', function (array $resources): object {
            $registrations = [];
            foreach ($resources as $name => $controller) {
                $registrations[] = Route::resource($name, $controller);
            }

            return new class($registrations)
            {
                public function __construct(protected array $registrations) {}

                public function paths(array $paths): void
                {
                    foreach ($this->registrations as $registration) {
                        $registration->paths($paths);
                    }
                }
            };
        });
    }
}
