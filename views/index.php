<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="public/css/index.css">
    <script src="public/js/scripts.js"></script>
</head>
<body>
    <div class="header">
        <h1>Product List</h1>
        <div class="actions">
            <div class="error-message"></div><br>
            <button onclick="window.location.href='views/add_product.php'">ADD</button>
            <button class="cancel" onclick="massDelete()">MASS DELETE</button>
        </div>
    </div>
    
    <hr>
    <form id="product_list" method="POST" action="public/massDelete.php">
        <div class="products">
            <?php if (!empty($products)): ?>
                <?php 
                // Define a mapping array
                $typeMapping = [
                    'DVD' => [
                        'query' => "SELECT size_mb AS attribute FROM dvd WHERE product_id = ?",
                        'unit' => 'MB',
                        'label' => 'Size:'
                    ],
                    'Book' => [
                        'query' => "SELECT weight_kg AS attribute FROM book WHERE product_id = ?",
                        'unit' => 'KG',
                        'label' => 'Weight:'
                    ],
                    'Furniture' => [
                        'query' => "SELECT CONCAT(height_cm, 'x', width_cm, 'x', length_cm) AS attribute FROM furniture WHERE product_id = ?",
                        'unit' => '',
                        'label' => 'Dimensions:'
                    ]
                ];
                ?>

                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <input type="checkbox" class="delete-checkbox" name="ids[]" value="<?= htmlspecialchars($product['id'] ?? '') ?>">
                        <p> <?= htmlspecialchars($product['sku'] ?? 'N/A') ?></p>
                        <p> <?= htmlspecialchars($product['name'] ?? 'N/A') ?></p>
                        <p> <?= htmlspecialchars($product['price'] ?? '0') ?> $</p>

                        <?php
                        // Get the product type
                        $type = $product['type'] ?? '';

                        // Get the corresponding query, unit, and label from the mapping array
                        $query = $typeMapping[$type]['query'] ?? '';
                        $unit = $typeMapping[$type]['unit'] ?? '';
                        $label = $typeMapping[$type]['label'] ?? 'Attribute:';

                        // Fetch the attribute if query exists
                        if ($query) {
                            $stmt = $conn->prepare($query);
                            $stmt->execute([$product['id']]);
                            $attribute = $stmt->fetch(PDO::FETCH_ASSOC);
                        } else {
                            $attribute = ['attribute' => 'N/A'];
                        }
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
