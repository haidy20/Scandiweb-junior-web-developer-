<?php
// classes/Product.php
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $conn;

    public function __construct($sku, $name, $price, $type, $conn) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->conn = $conn;
    }

    public function getSKU() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;
    }

    abstract public function save();
    abstract public function getAttributes();
}
?>
