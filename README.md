# Route Resource Paths Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amdadulhaq/route-resource-paths-laravel.svg?style=flat-square)](https://packagist.org/packages/amdadulhaq/route-resource-paths-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/amdadulhaq/route-resource-paths-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amdad121/route-resource-paths-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/amdad121/route-resource-paths-laravel/lint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/amdad121/route-resource-paths-laravel/actions?query=workflow%3A"Fix+Code+Style"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/amdadulhaq/route-resource-paths-laravel.svg?style=flat-square)](https://packagist.org/packages/amdadulhaq/route-resource-paths-laravel)

This Laravel package allows you to define custom paths for create and edit routes in resource controllers. It extends the functionality of Laravel's resource routing by providing macros to set these paths globally or for specific resources.

## Features

Set global custom paths for create and edit actions across all resource routes.
Customize paths individually for each resource route.
Works seamlessly with both Route::resource() and Route::resources() methods.

## Installation

You can install the package via composer:

```bash
composer require amdadulhaq/route-resource-paths-laravel
```

Once installed, the service provider will be registered automatically by Laravel.

## Configuration

No additional configuration is required. The package uses Laravel's built-in service container to bind and replace the default resource registrar.

## Usage

### Setting Global Paths

To set custom paths for the create and edit actions that will apply globally to all resource routes, use the Route::resourcePaths() method:

```php
Route::resourcePaths([
    'create' => 'add',
    'edit' => 'change',
]);
```

After setting these global paths, all resource routes defined using Route::resource() will use these custom paths instead of the default ones.

### Using Global Paths with Route::resource()

The global paths will automatically be applied to all resource controllers like this:

```php
Route::resource('posts', PostController::class);
```

This will generate routes such as:

GET /posts/add instead of GET /posts/create

GET /posts/{post}/change instead of GET /posts/{post}/edit

### Using Global Paths with Route::resources()

You can also use the global paths when registering multiple resource controllers at once:

```php
Route::resources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
])->paths([
    'create' => 'add',
    'edit' => 'change',
]);
```

This will apply the same custom paths to both photos and posts resource routes.

### Setting Custom Paths for Specific Resources

If you want to set custom paths for a specific resource, you can do so directly when defining the resource:

```php
Route::resource('users', UserController::class)->paths([
    'create' => 'add',
    'edit' => 'change',
]);
```

This will only affect the routes for the users resource:

GET /users/add instead of GET /users/create
GET /users/{user}/change instead of GET /users/{user}/edit

For Resource

```php
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class)->paths([
    'create' => 'add',
    'edit' => 'change',
]);
```

### Usage Example for Singleton Paths

To use the new Route::singletonPaths() method for setting global singleton paths, you can do the following:

```php
Route::singletonPaths([
    'create' => 'setup',
    'edit' => 'modify',
]);

Route::singleton('profile', ProfileController::class)->creatable()->paths([
    'create' => 'setup',
    'edit' => 'modify',
]);
```

This will generate the following routes for the ProfileController singleton resource:

GET /profile/setup instead of GET /profile/create

GET /profile/modify instead of GET /profile/edit

## Credits

-   [Amdadul Haq](https://github.com/amdad121)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Contributing

If you find any issues or have suggestions for improvements, feel free to create a pull request or open an issue on the [GitHub repository](https://github.com/amdad121/route-resource-paths-laravel).
