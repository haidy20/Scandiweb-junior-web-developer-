<?php

header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../config/database.php";
$database = new Database();
$conn = $database->getConnection();

$sku = $_POST['sku'];
$name = trim($_POST['name']);
$price = $_POST['price'];
$type = $_POST['type'];

$response = array();

// Check if the SKU already exists
$checkQuery = "SELECT COUNT(*) as count FROM products WHERE sku = :sku";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bindParam(':sku', $sku);
$checkStmt->execute();
$result = $checkStmt->fetch(PDO::FETCH_ASSOC);

if ($result['count'] > 0) {
    $response['status'] = 'error';
    $response['message'] = 'SKU already exists. Please provide a unique SKU.';
} else {
    // Proceed with the insertion
    $query = "INSERT INTO products (sku, name, price, type) VALUES (:sku, :name, :price, :type)";
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':sku', $sku);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':type', $type);

    // Execute the query
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Record was inserted successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Unable to insert record.';
    }
}

// Close the connection
$conn = null;

// Send the JSON response
echo json_encode($response);

?>
