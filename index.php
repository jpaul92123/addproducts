<?php
include_once 'includes/ProductController.php';

$productController = new ProductController();

// Código para manejar la visualización de productos y filtrado
$categories = $productController->getCategories();
$selectedCategory = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$subCategory = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : '';
$products = $productController->getProductsByCategory($selectedCategory, $subCategory);
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
            height: auto;
        }
        .container {
            margin-top: 20px;
        }
        .product-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .product-item img {
            margin-right: 10px;
        }
        .btn-update, .btn-delete {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Agregar Nuevo Producto</h1>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <form method="post" action="public/addProduct.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="categoria">Categoría:</label>
                        <select class="form-control" id="categoria" name="categoria" required>
                            <option value="">Seleccionar categoría</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>" <?php echo ($category == $selectedCategory) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategoria">Subcategoría:</label>
                        <select class="form-control" id="subcategoria" name="subcategoria" required>
                            <option value="">Seleccionar subcategoría</option>
                            <option value="subcat1">Subcategoría 1</option>
                            <option value="subcat2">Subcategoría 2</option>
                            <option value="subcat3">Subcategoría 3</option>
                        </select>
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
                    <div class="form-group">
                        <label for="imagen">Imagen:</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Producto</button>
                </form>
            </div>
            <div class="col-lg-6 col-md-12">
                <h2>Lista de Productos</h2>
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
                <div class="form-group">
                    <label for="selectSubCategory">Seleccionar subcategoría:</label>
                    <select id="selectSubCategory" class="form-control">
                        <option value="">Seleccionar subcategoría</option>
                        <option value="subcat1">Subcategoría 1</option>
                        <option value="subcat2">Subcategoría 2</option>
                        <option value="subcat3">Subcategoría 3</option>
                    </select>
                </div>
                <ul class="list-group">
                    <?php foreach ($products as $index => $product): ?>
                        <li class="list-group-item product-item">
                            <img src="images/<?php echo htmlspecialchars($product['imagen']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>" class="product-image">
                            <div>
                                <strong style="color:brown">S/. <?php echo htmlspecialchars($product['precio']); ?></strong><br>
                                <strong><?php echo htmlspecialchars($product['nombre']); ?></strong><br>
                                <p><?php echo htmlspecialchars($product['descripcion']); ?></p>
                            </div>
                            <div>
                                <a href="public/updateProduct.php?php echo urlencode($selectedCategory); ?>&subcategoria=<?php echo urlencode($subCategory); ?>&index=<?php echo $index; ?>" class="btn btn-warning btn-sm btn-update">Actualizar</a>
                                <a href="public/deleteProduct.php?php echo urlencode($selectedCategory); ?>&subcategoria=<?php echo urlencode($subCategory); ?>&index=<?php echo $index; ?>" class="btn btn-danger btn-sm btn-delete">Eliminar</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
    </div><br>

    <?php include "templates/footer.php" ?>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show success modal if message is set
            <?php if (isset($showModal) && $showModal): ?>
                $('#successModal').modal('show');
            <?php endif; ?>

            // Handle category and subcategory filtering
            $('#selectCategory, #selectSubCategory').change(function() {
                var category = $('#selectCategory').val();
                var subCategory = $('#selectSubCategory').val();
                window.location.href = 'index.php?categoria=' + encodeURIComponent(category) + '&subcategoria=' + encodeURIComponent(subCategory);
            });
        });
    </script>
</body>
</html>
