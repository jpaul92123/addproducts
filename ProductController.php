<?php
class ProductController {
    private $file_path = 'data/categorias.json';
    private $image_folder = 'data/images/';

    public function __construct() {
        // Ensure the file exists with default categories
        if (!file_exists($this->file_path)) {
            file_put_contents($this->file_path, json_encode([
                "polos" => [],
                "poleras" => [],
                "chompas" => [],
                "jeans" => [],
                "zapatillas" =>[]
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

    public function handleImageUpload($file) {
        $target_file = $this->image_folder . basename($file["name"]);
    
        // Create directory if it doesn't exist
        if (!is_dir($this->image_folder)) {
            mkdir($this->image_folder, 0777, true);
        }
    
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return "El archivo no es una imagen.";
        }
    
        // Check file size (5MB max)
        if ($file["size"] > 5000000) {
            return "El archivo es demasiado grande.";
        }
    
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            return "El archivo ya existe.";
        }
    
        // Try to upload file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return "El archivo ". htmlspecialchars(basename($file["name"])) . " ha sido subido.";
        } else {
            return "Hubo un error al subir el archivo.";
        }
    }
    
}
?>
