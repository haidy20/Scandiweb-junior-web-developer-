<?php
require_once 'config/database.php';
require_once 'controllers/ProductController.php';
// require_once 'controllers/MassDeleteController.php';

$database = new Database();
$conn = $database->getConnection();

$productController = new ProductController($conn);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // if (isset($_GET['action']) && $_GET['action'] === 'addProduct') {
    //     // Handle the add product form submission
    //     $sku = $_POST['sku'];
    //     $name = trim($_POST['name']);
    //     $price = $_POST['price'];
    //     $type = $_POST['type'];
    //     $attributes = [];

    //     // Server-side validation
    //     $errors = [];

    //     if (empty($sku)) {
    //         $errors[] = 'Please, submit required data';
    //     }

    //     if (empty($name)) {
    //         $errors[] = 'Please, submit required data';
    //     } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
    //         $errors[] = 'Please, provide the data of indicated type for Name.';
    //     }

    //     if (empty($price)) {
    //         $errors[] = 'Please, submit required data';
    //     } elseif (!is_numeric($price) || $price <= 0) {
    //         $errors[] = 'Please, provide the data of indicated type for Price.';
    //     }

    //     if (empty($type)) {
    //         $errors[] = 'Please, submit required data for Type.';
    //     } else {
    //         switch ($type) {
    //             case 'DVD':
    //                 if (empty($_POST['size'])) {
    //                     $errors[] = 'Please, submit required data';
    //                 } elseif (!is_numeric($_POST['size']) || $_POST['size'] <= 0) {
    //                     $errors[] = 'Please, provide the data of indicated type for Size.';
    //                 } else {
    //                     $attributes['size'] = $_POST['size'];
    //                 }
    //                 break;
    //             case 'Book':
    //                 if (empty($_POST['weight'])) {
    //                     $errors[] = 'Please, submit required data';
    //                 } elseif (!is_numeric($_POST['weight']) || $_POST['weight'] <= 0) {
    //                     $errors[] = 'Please, provide the data of indicated type for Weight.';
    //                 } else {
    //                     $attributes['weight'] = $_POST['weight'];
    //                 }
    //                 break;
    //             case 'Furniture':
    //                 if (empty($_POST['height']) || empty($_POST['width']) || empty($_POST['length'])) {
    //                     $errors[] = 'Please, submit required data';
    //                 } elseif (!is_numeric($_POST['height']) || $_POST['height'] <= 0 ||
    //                           !is_numeric($_POST['width']) || $_POST['width'] <= 0 ||
    //                           !is_numeric($_POST['length']) || $_POST['length'] <= 0) {
    //                     $errors[] = 'Please, provide the data of indicated type for Dimensions.';
    //                 } else {
    //                     $attributes['height'] = $_POST['height'];
    //                     $attributes['width'] = $_POST['width'];
    //                     $attributes['length'] = $_POST['length'];
    //                 }
    //                 break;
    //         }
    //     }

    //     if (!empty($errors)) {
    //         $errorMessage = implode('<br>', $errors);
    //         include 'views/addProduct.php'; // Re-display the form with error message
    //         exit;
    //     }

    //     try {
    //         $productController->addProduct($sku, $name, $price, $type, $attributes);
    //         header("Location: public/index.php"); 
    //         exit;
    //     } catch (Exception $e) {
    //         $errorMessage = $e->getMessage();
    //         include 'views/addProduct.php'; // Re-display the form with error message
    //         exit;
    //     }
    // } 
    
    // elseif (isset($_GET['action']) && $_GET['action'] === 'massDelete') {
    //     // Handle mass delete form submission
    //     $massDeleteController = new MassDeleteController($conn);
    //     $ids = $_POST['ids'];
        
    //     try {
    //         $massDeleteController->deleteProducts($ids);
    //         header("Location: ../index.php"); 
    //         exit;
    //     } catch (Exception $e) {
    //         $errorMessage = $e->getMessage();
    //         include 'views/index.php'; // Re-display the product list with error message
    //         exit;
    //     }
    // }
// }

$products = $productController->getAllProducts();
include 'views/index.php';
?>
