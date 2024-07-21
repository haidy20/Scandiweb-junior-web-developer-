<?php
// classes/Book.php
require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight, $conn) {
        parent::__construct($sku, $name, $price, 'Book', $conn);
        $this->weight = $weight;
    }

    public function save() {
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->sku, $this->name, $this->price, $this->type])) {
            $product_id = $this->conn->lastInsertId();
            $query = "INSERT INTO book (product_id, weight_kg) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$product_id, $this->weight]);
        }
    }

    public function getAttributes() {
        return ["weight" => $this->weight];
    }
}
?>
