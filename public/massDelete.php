<?php
require_once '../config/database.php';
require_once '../controllers/MassDeleteController.php';

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle mass delete form submission
    $massDeleteController = new MassDeleteController($conn);
    $ids = $_POST['ids'];

    try {
        $massDeleteController->deleteProducts($ids);
        header("Location: ../index.php");
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        include '../views/index.php'; 
        exit;
    }
}
