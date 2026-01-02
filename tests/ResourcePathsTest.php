<?php

declare(strict_types=1);

use AmdadulHaq\RouteResourcePathsLaravel\PathsResourceRegistrar;
use Illuminate\Support\Facades\Route;

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

it('generates correct create path with global configuration', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
    ]);

    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.create');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('posts/add');
});

it('generates correct edit path with global configuration', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'edit' => 'modify',
    ]);

    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.edit');

    expect($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('posts/{post}/modify');
});

it('allows per-resource path customization', function (): void {
    Route::resource('users', 'UserController')->paths([
        'create' => 'register',
        'edit' => 'update',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'users.create');

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'users.edit');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('users/register')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('users/{user}/update');
});

it('resource-specific paths override global paths', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    Route::resource('posts', 'PostController');
    Route::resource('users', 'UserController')->paths([
        'create' => 'register',
    ]);

    $routes = Route::getRoutes();

    $postsCreateRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.create');

    $usersCreateRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'users.create');

    expect($postsCreateRoute->uri)->toBe('posts/add')
        ->and($usersCreateRoute->uri)->toBe('users/register');
});

it('generates correct singleton create path', function (): void {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'create' => 'setup',
    ]);

    Route::singleton('profile', 'ProfileController')->creatable();

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'profile.create');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('profile/setup');
});

it('generates correct singleton edit path', function (): void {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'edit' => 'update',
    ]);

    Route::singleton('profile', 'ProfileController')->creatable();

    $routes = Route::getRoutes();

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'profile.edit');

    expect($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('profile/update');
});

it('allows per-singleton path customization', function (): void {
    Route::singleton('settings', 'SettingsController')->creatable()->paths([
        'create' => 'initialize',
        'edit' => 'change',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'settings.create');

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'settings.edit');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('settings/initialize')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('settings/change');
});

it('uses default paths when no custom paths are set', function (): void {
    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.create');

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.edit');

    expect($createRoute->uri)->toBe('posts/create')
        ->and($editRoute->uri)->toBe('posts/{post}/edit');
});

it('preserves other resource actions', function (): void {
    Route::resource('posts', 'PostController')->paths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    $routes = Route::getRoutes();

    $indexRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.index');

    $showRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.show');

    $storeRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'posts.store');

    expect($indexRoute)->not->toBeNull()
        ->and($showRoute)->not->toBeNull()
        ->and($storeRoute)->not->toBeNull();
});

it('applies paths to multiple resources registered with resources macro', function (): void {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'new',
        'edit' => 'edit',
    ]);

    Route::resources([
        'articles' => 'ArticleController',
        'pages' => 'PageController',
    ]);

    $routes = Route::getRoutes();

    $articlesCreateRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'articles.create');

    $pagesCreateRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'pages.create');

    expect($articlesCreateRoute)->not->toBeNull()
        ->and($articlesCreateRoute->uri)->toBe('articles/new')
        ->and($pagesCreateRoute)->not->toBeNull()
        ->and($pagesCreateRoute->uri)->toBe('pages/new');
});

it('can set both create and edit paths simultaneously', function (): void {
    Route::resource('products', 'ProductController')->paths([
        'create' => 'new-product',
        'edit' => 'edit-product',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'products.create');

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'products.edit');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('products/new-product')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('products/{product}/edit-product');
});

it('handles empty paths array', function (): void {
    Route::resource('comments', 'CommentController')->paths([]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'comments.create');

    $editRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'comments.edit');

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('comments/create')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toBe('comments/{comment}/edit');
});

it('works with resource namespacing', function (): void {
    Route::namespace('Admin')->resource('dashboard', 'DashboardController')->paths([
        'create' => 'new',
        'edit' => 'modify',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(fn ($route): bool => str_ends_with((string) $route->getName(), 'dashboard.create'));

    expect($createRoute)->not->toBeNull();
});
it('supports partial resource actions with custom paths', function (): void {
    Route::resource('books', 'BookController')
        ->only(['index', 'create', 'store'])
        ->paths([
            'create' => 'add-book',
        ]);

    $routes = Route::getRoutes();

    $indexRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'books.index');

    $createRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'books.create');

    $showRoute = collect($routes)->first(fn ($route): bool => $route->getName() === 'books.show');

    expect($indexRoute)->not->toBeNull()
        ->and($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toBe('books/add-book')
        ->and($showRoute)->toBeNull();
});
