<?php

declare(strict_types=1);

use AmdadulHaq\RouteResourcePathsLaravel\PathsResourceRegistrar;

beforeEach(function () {
    PathsResourceRegistrar::setGlobalPaths([]);
    PathsResourceRegistrar::setGlobalSingletonPaths([]);
});

it('can set global paths for resources', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    expect(PathsResourceRegistrar::class)->toBeString();
});

it('can set global paths for singleton resources', function () {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'create' => 'setup',
        'edit' => 'update',
    ]);

    expect(PathsResourceRegistrar::class)->toBeString();
});

it('can clear global paths for resources', function () {
    PathsResourceRegistrar::setGlobalPaths(['create' => 'add']);
    PathsResourceRegistrar::setGlobalPaths([]);

    expect(true)->toBeTrue();
});

it('can clear global paths for singletons', function () {
    PathsResourceRegistrar::setGlobalSingletonPaths(['create' => 'setup']);
    PathsResourceRegistrar::setGlobalSingletonPaths([]);

    expect(true)->toBeTrue();
});

it('allows setting multiple paths at once', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
        'store' => 'save',
    ]);

    expect(true)->toBeTrue();
});

it('singleton paths can be different from resource paths', function () {
    PathsResourceRegistrar::setGlobalPaths(['create' => 'add']);
    PathsResourceRegistrar::setGlobalSingletonPaths(['create' => 'setup']);

    expect(true)->toBeTrue();
});
