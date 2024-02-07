# Laravel CRUD Generator Package

A Laravel package to simplify the generation of CRUD (Create, Read, Update, Delete) operations.

## Installation

To install this package, use Composer:
``` 
composer require markgersaliaph/laravel-crud-generate
```

#Usage
After installation, you can use the provided Artisan command to generate CRUD files for a specific model:

```


## Publish Components

To publish components, use Composer:
``` 
php artisan crud:publish-components
```


This will create the following files:
```
resources/js/Components/Table.jsx
resources/js/Components/Pagination.jsx

```

You can just remove this from the generated components if you dont want to use this components

#Usage
After installation, you can use the provided Artisan command to generate CRUD files for a specific model:

```

php artisan generate:crud YourModel
```
Replace YourModel with the name of your Eloquent model.

This command will generate the necessary files, including the model, controller, views, and routes.

Example
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

It will also generate a route in web.php
Route::resource('products',App\Http\Controllers\ProductsController::class);

...
```