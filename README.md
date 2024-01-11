# Laravel CRUD Generator Package

A Laravel package to simplify the generation of CRUD (Create, Read, Update, Delete) operations.

## Installation

To install this package, use Composer:
```bash
composer require your-vendor-name/your-package-name
```

#Usage
After installation, you can use the provided Artisan command to generate CRUD files for a specific model:


``` 
bash 
php artisan generate:crud YourModel
```
Replace YourModel with the name of your Eloquent model.

This command will generate the necessary files, including the model, controller, views, and routes.

Example
To generate CRUD files for a "Product" model:

```
bash 
php artisan generate:crud Product 
```
This will create the following files:

app/Models/Product.php
app/Http/Controllers/ProductController.php
resources/views/product/create.blade.php
resources/views/product/index.blade.php
...