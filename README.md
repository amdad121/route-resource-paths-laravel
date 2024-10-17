# Route Resource Paths for Laravel
A Laravel package that provides a custom resource registrar with support for custom paths.


## Installation

You can install the package via composer:

```bash
composer amdad121/route-resource-paths-laravel
```

## Usage

```php
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class)->paths([
    'create' => 'add',
    'edit' => 'change',
]);
```
## Credits

-   [Amdadul Haq](https://github.com/amdad121)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
