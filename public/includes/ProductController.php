<?php
class ProductController {
    private $jsonFile = '../data/products.json';

    public function handleImageUpload($file) {
        $targetDir = '../public/images/';
        $targetFile = $targetDir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return "El archivo no es una imagen.";
        }

        // Check file size
        if ($file["size"] > 500000) {
            return "El archivo es demasiado grande.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "webp" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            return "El archivo ya existe.";
        }

        // Attempt to upload the file
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "";
        } else {
            return "Hubo un error al subir el archivo.";
        }
    }

    public function addProduct($category, $subCategory, $name, $price, $description, $image) {
        $error = $this->handleImageUpload($image);
        if ($error) {
            return $error;
        }

        $products = $this->getAllProducts();
        $products[$category][$subCategory][] = [
            'nombre' => $name,
            'precio' => $price,
            'descripcion' => $description,
            'imagen' => $image['name']
        ];
        file_put_contents($this->jsonFile, json_encode($products, JSON_PRETTY_PRINT));
        return "Producto agregado exitosamente.";
    }

    public function getAllProducts() {
        if (!file_exists($this->jsonFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->jsonFile), true);
    }

    public function getCategories() {
        $products = $this->getAllProducts();
        return array_keys($products);
    }

    public function getProductsByCategory($category, $subCategory) {
        $products = $this->getAllProducts();
        return isset($products[$category][$subCategory]) ? $products[$category][$subCategory] : [];
    }

    public function updateProduct($category, $subCategory, $index, $name, $price, $description, $image) {
        $products = $this->getAllProducts();
        if (!isset($products[$category][$subCategory][$index])) {
            return "El producto no existe.";
        }

        if ($image['name']) {
            $error = $this->handleImageUpload($image);
            if ($error) {
                return $error;
            }
            $products[$category][$subCategory][$index]['imagen'] = $image['name'];
        }

        $products[$category][$subCategory][$index]['nombre'] = $name;
        $products[$category][$subCategory][$index]['precio'] = $price;
        $products[$category][$subCategory][$index]['descripcion'] = $description;

        file_put_contents($this->jsonFile, json_encode($products, JSON_PRETTY_PRINT));
        return "Producto actualizado exitosamente.";
    }

    public function deleteProduct($category, $subCategory, $index) {
        $products = $this->getAllProducts();
        if (!isset($products[$category][$subCategory][$index])) {
            return "El producto no existe.";
        }

        unset($products[$category][$subCategory][$index]);
        $products[$category][$subCategory] = array_values($products[$category][$subCategory]);
        file_put_contents($this->jsonFile, json_encode($products, JSON_PRETTY_PRINT));
        return "Producto eliminado exitosamente.";
    }
}
?>
