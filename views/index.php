<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="../public/css/index.css">
    <script src="../public/js/scripts.js"></script>
</head>
<body>
    <div class="header">
        <h1>Product List</h1>
        <div class="actions">
            <div class="error-message"></div><br>
            <button onclick="window.location.href='../views/add_product.php'">ADD</button>
            <button class="cancel" onclick="massDelete()">MASS DELETE</button>
        </div>
    </div>
    <hr>
    <form id="product_list" method="POST" action="../public/index.php?action=massDelete">
        <div class="products">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <input type="checkbox" class="delete-checkbox" name="ids[]" value="<?= htmlspecialchars($product['id'] ?? '') ?>">
                        <p> <?= htmlspecialchars($product['sku'] ?? 'N/A') ?></p>
                        <p> <?= htmlspecialchars($product['name'] ?? 'N/A') ?></p>
                        <p> <?= htmlspecialchars($product['price'] ?? '0') ?> $</p>
                        <?php
                        switch ($product['type']) {
                            case 'DVD':
                                $query = "SELECT size_mb AS attribute FROM dvd WHERE product_id = ?";
                                $unit = 'MB';
                                $label = 'Size:';
                                break;
                            case 'Book':
                                $query = "SELECT weight_kg AS attribute FROM book WHERE product_id = ?";
                                $unit = 'KG';
                                $label = 'Weight:';
                                break;
                            case 'Furniture':
                                $query = "SELECT CONCAT(height_cm, 'x', width_cm, 'x', length_cm) AS attribute FROM furniture WHERE product_id = ?";
                                $unit = '';
                                $label = 'Dimensions:';
                                break;
                            default:
                                $attribute = ['attribute' => 'N/A'];
                                $unit = '';
                                $label = 'Attribute:';
                                break;
                        }
                        $stmt = $conn->prepare($query);
                        $stmt->execute([$product['id']]);
                        $attribute = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <p><?= $label ?> <?= htmlspecialchars($attribute['attribute'] ?? 'N/A') ?> <?= $unit ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </form>

</body>
</html>
