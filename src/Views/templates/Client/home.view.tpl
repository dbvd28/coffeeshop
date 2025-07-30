<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Productos - Página Principal</title>
    <style>
        .product {
            border: 1px solid #ccc; 
            padding: 15px; 
            margin: 10px; 
            width: 220px;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }
        .product img {
            max-width: 180px;
            height: auto;
        }
        button {
            margin-top: 10px;
            padding: 7px 15px;
            cursor: pointer;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, estos son nuestros productos disponibles</h1>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?= htmlspecialchars($product['productImgUrl']) ?>" alt="<?= htmlspecialchars($product['productName']) ?>" />
                <h3><?= htmlspecialchars($product['productName']) ?></h3>
                <p><?= htmlspecialchars(substr($product['productDescription'], 0, 60)) ?>...</p>
                <p><strong>Precio:</strong> $<?= number_format($product['productPrice'], 2) ?></p>
                <button type="button">Agregar al carrito</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
