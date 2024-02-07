
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

## Publish Components
To publish components, use Artisan:

```
php artisan crud:publish-components

```
This will create the following files:

```
resources/js/Components/Table.jsx
resources/js/Components/Pagination.jsx
```

You can remove these generated components if you don't want to use them.

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
 