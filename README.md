
# Laravel Breeze React CRUD Generator Package 
<p align="center">
    <a href="https://packagist.org/packages/markgersaliaph/laravel-crud-generate">
        <img src="https://img.shields.io/packagist/dt/markgersaliaph/laravel-crud-generate" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/markgersaliaph/laravel-crud-generate">
        <img src="https://img.shields.io/packagist/v/markgersaliaph/laravel-crud-generate" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/markgersaliaph/laravel-crud-generate">
        <img src="https://img.shields.io/packagist/l/markgersaliaph/laravel-crud-generate" alt="License">
    </a>
</p>

## Introduction
This Laravel package simplifies the process of creating CRUD (Create, Read, Update, Delete) operations specifically for the Laravel Breeze React starter.

## Requirements
Before installing, make sure to install Laravel Breeze with React:

```
composer require laravel/breeze --dev
```
Follow the instructions to set up Laravel Breeze with React.


## Installation

To install this package, use Composer:

```
composer require markgersaliaph/laravel-crud-generate
```
## Getting Started

### Publish Configuration and React Components

To use the Laravel CRUD Generate package in your Laravel project, you'll need to publish the configuration file and React components. Follow these steps:

1. **Publish Configuration File:**

   Run the following Artisan command to publish the configuration file:

   ```bash
   php artisan vendor:publish --tag=public --provider="Markgersaliaph\LaravelCrudGenerate\LaravelCrudGenerateServiceProvider"

## Configure Package
After publishing the configuration file, you can customize the behavior of Laravel CRUD Generate by modifying

```config/laravel-crud-generate.php```

in your Laravel project. Adjust the values according to your requirements.

## Usage
After installation, use the provided Artisan command to generate CRUD files for a specific model:

```
php artisan generate:crud YourModel
```
Replace YourModel with the name of your Eloquent model. This command will generate the necessary files, including the model,migrations, controller, react components, and routes.

### Example:
To generate CRUD files for a "Product" model:

```
php artisan generate:crud Product

```
This will create the following files:

```
app/Models/Product.php
app/Http/Controllers/ProductController.php
database/migrations/create_products_table.php
resources/js/Pages/Form.jsx
resources/js/Pages/List.jsx
``` 
It will also generate a route in web.php:

```
Route::resource('products', App\Http\Controllers\ProductsController::class);

```


## Generating Components with Built-In Components

If you prefer to use built-in components, follow these steps:

1. Open the configuration file located at `config/laravel-crud-generate.php`.

2. Set the `'plain_components'` option to `false`:

    ```php
    // config/laravel-crud-generate.php

    return [
        'plain_components' => false,
        // Additional configuration options...
    ];
    ```

   This configuration change will enable the use of built-in components such as `Table.jsx` and `Pagination.jsx` in your Laravel project.

Now, when generating components with Laravel CRUD Generate, the components will be included based on the updated configuration.

 