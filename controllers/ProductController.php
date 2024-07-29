<?php
// controllers/ProductController.php
require_once 'config/database.php';
require_once 'classes/DVD.php';
require_once 'classes/Book.php';
require_once 'classes/Furniture.php';

class ProductController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addProduct($sku, $name, $price, $type, $attributes) {
        switch ($type) {
            case 'DVD':
                $product = new DVD($sku, $name, $price, $attributes['size'], $this->conn);
                break;
            case 'Book':
                $product = new Book($sku, $name, $price, $attributes['weight'], $this->conn);
                break;
            case 'Furniture':
                $product = new Furniture($sku, $name, $price, $attributes['height'], $attributes['width'], $attributes['length'], $this->conn);
                break;
            default:
                throw new Exception("Invalid product type!");
        }
        $product->save();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
