<?php
include_once 'ProductController.php';

// Create a new ProductController object
$productController = new ProductController();

// Initialize message
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

    if ($imagen && $nombre && $precio && $descripcion && $categoria) {
        // Add product and generate JSON
        $message = $productController->addProduct($imagen, $nombre, $precio, $descripcion, $categoria);
    } else {
        $message = "Todos los campos son obligatorios.";
    }
}

// Get the list of categories
$categories = $productController->getCategories();

// Get products by category
$selectedCategory = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$products = $productController->getProductsByCategory($selectedCategory);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100px;
            height: 80%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Agregar Nuevo Producto</h1>
        
        <form method="post" action="" class="mt-4">
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>">
                            <?php echo htmlspecialchars($category); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen (ruta):</label>
                <input type="text" class="form-control" id="imagen" name="imagen" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" onclick="showSuccessModal()">Agregar Producto</button>
        </form>

        <h2 class="mt-5">Lista de Productos</h2>
        <div class="form-group">
            <label for="selectCategory">Seleccionar categoría:</label>
            <select id="selectCategory" class="form-control">
                <option value="">Seleccionar categoría</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category); ?>" <?php echo ($category == $selectedCategory) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <ul class="list-group">
            <?php foreach ($products as $product): ?>
                <li class="list-group-item">
                    <img src="<?php echo htmlspecialchars($product['imagen']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>" class="product-image">
                    <strong><?php echo htmlspecialchars($product['nombre']); ?></strong><br>
                    Precio: S/ <?php echo htmlspecialchars($product['precio']); ?><br>
                    Descripción: <?php echo htmlspecialchars($product['descripcion']); ?><br>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showSuccessModal() {
            $('#successModal').modal('show');
        }

        // Handle category change
        document.getElementById('selectCategory').addEventListener('change', function() {
            var category = this.value;
            if (category) {
                window.location.href = '?categoria=' + category;
            } else {
                window.location.href = '';
            }
        });
    </script>
</body>
</html>
