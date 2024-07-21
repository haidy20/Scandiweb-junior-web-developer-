<?php
// classes/DVD.php
require_once 'Product.php';

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size, $conn) {
        parent::__construct($sku, $name, $price, 'DVD', $conn);
        $this->size = $size;
    }

    public function save() {
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->sku, $this->name, $this->price, $this->type])) {
            $product_id = $this->conn->lastInsertId();
            $query = "INSERT INTO dvd (product_id, size_mb) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$product_id, $this->size]);
        }
    }

    public function getAttributes() {
        return ["size" => $this->size];
    }
}
?>
