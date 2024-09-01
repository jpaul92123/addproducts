<?php
include_once 'includes/ProductController.php';

$productController = new ProductController();
$categories = $productController->getCategories();

$category = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$subCategory = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : '';
$index = isset($_GET['index']) ? $_GET['index'] : '';

$product = $productController->getProductsByCategory($category, $subCategory);
$product = isset($product[$index]) ? $product[$index] : [];

if (!$product) {
    die("Producto no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Actualizar Producto</h1>
        <form method="post" action="updateProduct.php" enctype="multipart/form-data">
            <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($category); ?>">
            <input type="hidden" name="subcategoria" value="<?php echo htmlspecialchars($subCategory); ?>">
            <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($product['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($product['precio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
                <small>Dejar en blanco si no desea cambiar la imagen.</small>
                <div class="mt-2">
                    <img src="images/<?php echo htmlspecialchars($product['imagen']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>" class="img-thumbnail" style="max-width: 200px;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
