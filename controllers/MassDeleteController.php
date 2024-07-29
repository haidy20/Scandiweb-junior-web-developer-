<?php
// controllers/MassDeleteController.php
require_once 'config/database.php';

class MassDeleteController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function deleteProducts($ids) {
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $query = "DELETE FROM products WHERE id IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($ids);
        }
        return false;
    }
}
?>
