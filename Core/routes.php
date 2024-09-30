<?php

$router->get('/', "index.php");

$router->get('/add-product', "newProduct/show.php");
$router->post('/add-product', "newProduct/add.php");

$router->get('/products', "products.php");

// Route to fetch all products
$router->get('/get-products', "fetchProducts/products.php");

// Route to fetch a single product by ID
$router->get('/get-products/{id}', "fetchProducts/product.php");

// login
$router->post('/login', "login.php");
$router->post('/register', "register.php");
