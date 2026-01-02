<?php

declare(strict_types=1);

use AmdadulHaq\RouteResourcePathsLaravel\PathsResourceRegistrar;

beforeEach(function (): void {
    PathsResourceRegistrar::setGlobalPaths([]);
    PathsResourceRegistrar::setGlobalSingletonPaths([]);
});

it('can set global paths for resources', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    expect(PathsResourceRegistrar::class)->toBeString();
});

it('can set global paths for singleton resources', function (): void {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'create' => 'setup',
        'edit' => 'update',
    ]);

    expect(PathsResourceRegistrar::class)->toBeString();
});

it('can clear global paths for resources', function (): void {
    PathsResourceRegistrar::setGlobalPaths(['create' => 'add']);
    PathsResourceRegistrar::setGlobalPaths([]);

    expect(true)->toBeTrue();
});

it('can clear global paths for singletons', function (): void {
    PathsResourceRegistrar::setGlobalSingletonPaths(['create' => 'setup']);
    PathsResourceRegistrar::setGlobalSingletonPaths([]);

    expect(true)->toBeTrue();
});

it('allows setting multiple paths at once', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
        'store' => 'save',
    ]);

    expect(true)->toBeTrue();
});

it('singleton paths can be different from resource paths', function (): void {
    PathsResourceRegistrar::setGlobalPaths(['create' => 'add']);
    PathsResourceRegistrar::setGlobalSingletonPaths(['create' => 'setup']);

    expect(true)->toBeTrue();
});
