Laravel Healthchecks
====================

![CI](https://github.com/renoki-co/laravel-healthchecks/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-healthchecks/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-healthchecks/branch/master)
[![StyleCI](https://github.styleci.io/repos/264111394/shield?branch=master)](https://github.styleci.io/repos/264111394)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-healthchecks/v/stable)](https://packagist.org/packages/renoki-co/laravel-healthchecks)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-healthchecks/downloads)](https://packagist.org/packages/renoki-co/laravel-healthchecks)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-healthchecks/d/monthly)](https://packagist.org/packages/renoki-co/laravel-healthchecks)
[![License](https://poser.pugx.org/renoki-co/laravel-healthchecks/license)](https://packagist.org/packages/renoki-co/laravel-healthchecks)

Laravel Healthchecks is a simple controller class that enables the possibility of building your own healthchecks endpoint without issues.

## 🚀 Installation

You can install the package via composer:

```bash
composer require renoki-co/laravel-healthchecks
```

## 🙌 Usage

First of all, you should create your own Controller for healthchecks, that extends the `RenokiCo\LaravelHealthchecks\Http\Controllers\HealthcheckController`.

``` php
use App\User;
use Illuminate\Http\Request;
use RenokiCo\LaravelHealthchecks\Http\Controllers\HealthcheckController;

class MyHealthcheckController extends HealthcheckController
{
    /**
     * Register the healthchecks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function registerHealthchecks(Request $request)
    {
        $this->addHealthcheck('mysql', function (Request $request) {
            // Try testing the MySQL connection here
            // and return true/false for pass/fail.

            return true;
        });
    }
}
```

```php
// In your routes
Route::get('/healthcheck', 'MyHealthcheckController@handle');
```

## Registering healthchecks

Within the controller, you should register the healthchecks closures in the `registerHealthchecks` method, like the example stated above.

You can add as many healthchecks as you want.

```php
public function registerHealthchecks(Request $request)
{
    $this->addHealthcheck('mysql', function (Request $request) {
        //
    });

    $this->addHealthcheck('redis', function (Request $request) {
        //
    });

    $this->addHealthcheck('some_check', function (Request $request) {
        //
    });

    $this->addHealthcheck('another_check_here', function (Request $request) {
        //
    });
}
```

## Status Codes

In case of failure, the response is `500`. For all successful responses, the status code is `200`.

## Outputs

By default, the output will be `OK` or `FAIL` as string, but in case you want to debug the healthchecks, you can get a JSON with each registered healthchecks and their pass/fail closures.

You have just to call `withOutput()`:

```php
public function registerHealthchecks(Request $request)
{
    $this->withOutput();

    $this->addHealthcheck('mysql', function (Request $request) {
        return true;
    });

    $this->addHealthcheck('redis', function (Request $request) {
        return false;
    });
}
```

The output in the browser would be like this:

```json
{
    "mysql": true,
    "redis": false
}
```

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
