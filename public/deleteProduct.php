<?php
include_once '../includes/ProductController.php';

$productController = new ProductController();
$message = '';

if (isset($_GET['categoria'], $_GET['subcategoria'], $_GET['index'])) {
    $message = $productController->deleteProduct(
        $_GET['categoria'],
        $_GET['subcategoria'],
        $_GET['index']
    );
}

header('Location: ../index.php?showModal=true&message=' . urlencode($message));
exit();
?>
