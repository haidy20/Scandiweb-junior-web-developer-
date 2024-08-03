<?php

header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', '0');

include "../config/database.php";

$response = array();

try {
    $database = new Database();
    $conn = $database->getConnection();

    $sku = $_POST['sku'];
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $type = $_POST['type'];

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
            $lastInsertId = $conn->lastInsertId();
            $response['status'] = 'success';

            // Mapping for additional attributes
            $typeMapping = [
                'DVD' => [
                    'query' => "INSERT INTO dvd (product_id, size_mb) VALUES (:product_id, :size)",
                    'attributes' => ['size' => $_POST['size']],
                    'label' => 'Size',
                    'unit' => 'MB'
                ],
                'Book' => [
                    'query' => "INSERT INTO book (product_id, weight_kg) VALUES (:product_id, :weight)",
                    'attributes' => ['weight' => $_POST['weight']],
                    'label' => 'Weight',
                    'unit' => 'KG'
                ],
                'Furniture' => [
                    'query' => "INSERT INTO furniture (product_id, height_cm, width_cm, length_cm) VALUES (:product_id, :height, :width, :length)",
                    'attributes' => [
                        'height' => $_POST['height'],
                        'width' => $_POST['width'],
                        'length' => $_POST['length']
                    ],
                    'label' => 'Dimensions',
                    'unit' => ''
                ]
            ];

            // Execute the additional query based on type
            if (isset($typeMapping[$type])) {
                $mapping = $typeMapping[$type];
                $extraStmt = $conn->prepare($mapping['query']);
                $extraStmt->bindParam(':product_id', $lastInsertId);
                foreach ($mapping['attributes'] as $key => $value) {
                    $extraStmt->bindParam(":$key", $value);
                }
                if ($extraStmt->execute()) {
                    $response['message'] = 'Record was inserted successfully. ' . $mapping['label'] . ': ' . htmlspecialchars($_POST[array_key_first($mapping['attributes'])]) . ' ' . $mapping['unit'];
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Unable to insert additional attributes.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid product type.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unable to insert record.';
        }
    }

    // Close the connection
    $conn = null;

} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Please, submit required data.';
}

// Send the JSON response
echo json_encode($response);

?>
