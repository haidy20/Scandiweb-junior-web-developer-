<?php
require_once 'config/database.php';
require_once 'controllers/ProductController.php';
// require_once 'controllers/MassDeleteController.php';

$database = new Database();
$conn = $database->getConnection();

$productController = new ProductController($conn);
$products = $productController->getAllProducts();
include 'views/index.php';
?>
