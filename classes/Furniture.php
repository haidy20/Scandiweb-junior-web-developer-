<?php
// classes/Furniture.php
require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length, $conn) {
        parent::__construct($sku, $name, $price, 'Furniture', $conn);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function save() {
        $query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->sku, $this->name, $this->price, $this->type])) {
            $product_id = $this->conn->lastInsertId();
            $query = "INSERT INTO furniture (product_id, height_cm, width_cm, length_cm) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$product_id, $this->height, $this->width, $this->length]);
        }
    }

    public function getAttributes() {
        return [
            "height" => $this->height,
            "width" => $this->width,
            "length" => $this->length
        ];
    }
}
?>
