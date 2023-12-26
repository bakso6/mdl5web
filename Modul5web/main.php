<?php
header("Content-Type: application/json; charset=UTF-8");

include "app/Routes/ProductRoutes.php";

use app\Routes\ProductRoutes;

//TANGKAP REQUEST METHOD
$method = $_SERVER['REQUEST_METHOD'];
// TANGKAP REQUEST PATH
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// PANGGIL ROUTES
$productRoutes = new ProductRoutes();
$productRoutes->handle($method, $path);
