<?php

declare(strict_types=1);

namespace AmdadulHaq\RouteResourcePathsLaravel\Tests;

use AmdadulHaq\RouteResourcePathsLaravel\RouteResourcesPathsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            RouteResourcesPathsServiceProvider::class,
        ];
    }
}
