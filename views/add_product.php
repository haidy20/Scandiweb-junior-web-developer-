<!DOCTYPE html>
<html>
<head>
    <title>Product Add</title>
    <link rel="stylesheet" type="text/css" href="../public/css/addProduct.css">
    <script src="../public/js/scripts.js"></script>
</head>
<body>
    <div class="header">
        <h1>Product Add</h1>
        <div class="actions">
            <button type="submit" form="product_form" onclick="return validateForm()">Save</button>
            <button class="cancel" onclick="window.location.href='../index.php'">Cancel</button>
        </div>
    </div>
    <hr>
    <h4 id="success" class="success" style="text-align: center; color: #28a745; width: 100%;"> </h4>

    <form id="product_form" method="POST" action="../public/addProduct.php">
        <label for="sku">SKU:</label>
        <input type="text" id="sku" name="sku">
        <div class="error-message" id="sku-error"></div><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        <div class="error-message" id="name-error"></div><br>

        <label for="price">Price ($):</label>
        <input type="number" id="price" name="price" step="0.01">
        <div class="error-message" id="price-error"></div><br>

        <label for="type">Type Switcher:</label>
        <select id="type" name="type" onchange="handleTypeChange()">
            <option value="">Select Type</option>
            <option value="Book">Book</option>
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
        </select>
        <div class="error-message" id="type-error"></div><br>

        <div id="type_specific_fields"></div>
        <div id="dynamic-description" class="dynamic-description"></div>
    </form>
    <footer class="footer">
        <hr>
        Scandiweb test assignment
    </footer>
</body>
</html>
