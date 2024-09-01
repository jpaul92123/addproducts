<?php
include_once 'includes/ProductController.php';

$productController = new ProductController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $productController->addProduct(
        $_POST['categoria'],
        $_POST['subcategoria'],
        $_POST['nombre'],
        $_POST['precio'],
        $_POST['descripcion'],
        $_FILES['imagen']
    );
}

header('Location: index.php?showModal=true&message=' . urlencode($message));
exit();
?>
