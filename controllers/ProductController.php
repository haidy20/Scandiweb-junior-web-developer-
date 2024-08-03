<?php
// controllers/ProductController.php
require_once 'config/database.php';
require_once 'classes/DVD.php';
require_once 'classes/Book.php';
require_once 'classes/Furniture.php';



// using factory pattern instead of switch case statement
class ProductController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addProduct($sku, $name, $price, $type, $attributes) {
        $product = $this->createProduct($sku, $name, $price, $type, $attributes);
        $product->save();
    }

    private function createProduct($sku, $name, $price, $type, $attributes) {
        $productTypes = [
            'DVD' => function() use ($sku, $name, $price, $attributes) {
                return new DVD($sku, $name, $price, $attributes['size'], $this->conn);
            },
            'Book' => function() use ($sku, $name, $price, $attributes) {
                return new Book($sku, $name, $price, $attributes['weight'], $this->conn);
            },
            'Furniture' => function() use ($sku, $name, $price, $attributes) {
                return new Furniture($sku, $name, $price, $attributes['height'], $attributes['width'], $attributes['length'], $this->conn);
            }
        ];

        if (!isset($productTypes[$type])) {
            throw new Exception("Invalid product type!");
        }

        return $productTypes[$type]();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
