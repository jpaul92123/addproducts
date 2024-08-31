<?php
class ProductController {
    private $file_path = 'data/categorias.json';

    public function __construct() {
        // Ensure the file exists with default categories
        if (!file_exists($this->file_path)) {
            file_put_contents($this->file_path, json_encode([
                "polos" => [],
                "poleras" => [],
                "jeans" => [],
                "zapatillas" => [],
                "chompas" => []
            ], JSON_PRETTY_PRINT));
        }
    }

    public function addProduct($imagen, $nombre, $precio, $descripcion, $categoria) {
        $data = [
            "imagen" => $imagen,
            "nombre" => $nombre,
            "precio" => $precio,
            "descripcion" => $descripcion
        ];

        // Load existing categories
        $jsonData = file_get_contents($this->file_path);
        $arrayData = json_decode($jsonData, true);

        // Ensure the category exists
        if (!isset($arrayData[$categoria])) {
            $arrayData[$categoria] = [];
        }

        // Add the product to the selected category
        $arrayData[$categoria][] = $data;

        // Save the updated data
        file_put_contents($this->file_path, json_encode($arrayData, JSON_PRETTY_PRINT));

        return "Producto agregado exitosamente.";
    }

    public function getCategories() {
        $jsonData = file_get_contents($this->file_path);
        $arrayData = json_decode($jsonData, true);

        return array_keys($arrayData);
    }

    public function getProductsByCategory($categoria) {
        $jsonData = file_get_contents($this->file_path);
        $arrayData = json_decode($jsonData, true);

        return isset($arrayData[$categoria]) ? $arrayData[$categoria] : [];
    }
}
?>
