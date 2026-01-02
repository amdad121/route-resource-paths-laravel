<?php

declare(strict_types=1);

use AmdadulHaq\RouteResourcePathsLaravel\PathsResourceRegistrar;
use Illuminate\Support\Facades\Route;

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

it('generates correct create path with global configuration', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
    ]);

    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.create';
    });

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/posts/add');
});

it('generates correct edit path with global configuration', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'edit' => 'modify',
    ]);

    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.edit';
    });

    expect($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/posts/{post}/modify');
});

it('allows per-resource path customization', function () {
    Route::resource('users', 'UserController')->paths([
        'create' => 'register',
        'edit' => 'update',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'users.create';
    });

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'users.edit';
    });

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/users/register')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/users/{user}/update');
});

it('resource-specific paths override global paths', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    Route::resource('posts', 'PostController');
    Route::resource('users', 'UserController')->paths([
        'create' => 'register',
    ]);

    $routes = Route::getRoutes();

    $postsCreateRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.create';
    });

    $usersCreateRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'users.create';
    });

    expect($postsCreateRoute->uri)->toContain('/posts/add')
        ->and($usersCreateRoute->uri)->toContain('/users/register');
});

it('generates correct singleton create path', function () {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'create' => 'setup',
    ]);

    Route::singleton('profile', 'ProfileController')->creatable();

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'profile.create';
    });

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/profile/setup');
});

it('generates correct singleton edit path', function () {
    PathsResourceRegistrar::setGlobalSingletonPaths([
        'edit' => 'update',
    ]);

    Route::singleton('profile', 'ProfileController')->creatable();

    $routes = Route::getRoutes();

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'profile.edit';
    });

    expect($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/profile/update');
});

it('allows per-singleton path customization', function () {
    Route::singleton('settings', 'SettingsController')->creatable()->paths([
        'create' => 'initialize',
        'edit' => 'change',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'settings.create';
    });

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'settings.edit';
    });

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/settings/initialize')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/settings/change');
});

it('uses default paths when no custom paths are set', function () {
    Route::resource('posts', 'PostController');

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.create';
    });

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.edit';
    });

    expect($createRoute->uri)->toContain('/posts/create')
        ->and($editRoute->uri)->toContain('/posts/{post}/edit');
});

it('preserves other resource actions', function () {
    Route::resource('posts', 'PostController')->paths([
        'create' => 'add',
        'edit' => 'modify',
    ]);

    $routes = Route::getRoutes();

    $indexRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.index';
    });

    $showRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.show';
    });

    $storeRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'posts.store';
    });

    expect($indexRoute)->not->toBeNull()
        ->and($showRoute)->not->toBeNull()
        ->and($storeRoute)->not->toBeNull();
});

it('applies paths to multiple resources registered with resources macro', function () {
    PathsResourceRegistrar::setGlobalPaths([
        'create' => 'new',
        'edit' => 'edit',
    ]);

    Route::resources([
        'articles' => 'ArticleController',
        'pages' => 'PageController',
    ]);

    $routes = Route::getRoutes();

    $articlesCreateRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'articles.create';
    });

    $pagesCreateRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'pages.create';
    });

    expect($articlesCreateRoute)->not->toBeNull()
        ->and($articlesCreateRoute->uri)->toContain('/articles/new')
        ->and($pagesCreateRoute)->not->toBeNull()
        ->and($pagesCreateRoute->uri)->toContain('/pages/new');
});

it('can set both create and edit paths simultaneously', function () {
    Route::resource('products', 'ProductController')->paths([
        'create' => 'new-product',
        'edit' => 'edit-product',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'products.create';
    });

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'products.edit';
    });

    expect($createRoute)->not->BeNull()
        ->and($createRoute->uri)->toContain('/products/new-product')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/products/{product}/edit-product');
});

it('handles empty paths array', function () {
    Route::resource('comments', 'CommentController')->paths([]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'comments.create';
    });

    $editRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'comments.edit';
    });

    expect($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/comments/create')
        ->and($editRoute)->not->toBeNull()
        ->and($editRoute->uri)->toContain('/comments/{comment}/edit');
});

it('works with resource namespacing', function () {
    Route::namespace('Admin')->resource('dashboard', 'DashboardController')->paths([
        'create' => 'new',
        'edit' => 'modify',
    ]);

    $routes = Route::getRoutes();

    $createRoute = collect($routes)->first(function ($route) {
        return str_ends_with($route->getName(), 'dashboard.create');
    });

    expect($createRoute)->not->toBeNull();
});
it('supports partial resource actions with custom paths', function () {
    Route::resource('books', 'BookController')
        ->only(['index', 'create', 'store'])
        ->paths([
            'create' => 'add-book',
        ]);

    $routes = Route::getRoutes();

    $indexRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'books.index';
    });

    $createRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'books.create';
    });

    $showRoute = collect($routes)->first(function ($route) {
        return $route->getName() === 'books.show';
    });

    expect($indexRoute)->not->toBeNull()
        ->and($createRoute)->not->toBeNull()
        ->and($createRoute->uri)->toContain('/books/add-book')
        ->and($showRoute)->toBeNull();
});
