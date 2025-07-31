<?php
// File: app/models/Product.php (Versi Final & Lengkap)

class Product {
    private $conn;
    private $table = 'products';
    private $upload_dir = __DIR__ . '/../../public/images/products/';

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- FUNGSI UTAMA CRUD ---

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM " . $this->table . " WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function create($data, $file) {
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $price = (int)$data['price'];
        $stock = (int)$data['stock'];
        $image_url = $this->uploadImage($file);
        
        $query = "INSERT INTO " . $this->table . " (name, price, stock, image_url) VALUES ('$name', '$price', '$stock', '$image_url')";
        return mysqli_query($this->conn, $query);
    }
    
    public function update($id, $data, $file) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $price = (int)$data['price'];
        $stock = (int)$data['stock'];
        $image_url = '';

        if (isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            $this->deleteImage($id);
            $image_url = $this->uploadImage($file);
        }

        $query = "UPDATE " . $this->table . " SET name = '$name', price = '$price', stock = '$stock'";
        if ($image_url && $image_url !== 'default.jpg') {
            $query .= ", image_url = '$image_url'";
        }
        $query .= " WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
    
    public function delete($id) {
        $id = (int)$id;
        $this->deleteImage($id);
        $query = "DELETE FROM " . $this->table . " WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }

    // --- FUNGSI HELPER GAMBAR ---

    private function uploadImage($file) {
        if (isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            if (!is_dir($this->upload_dir) || !is_writable($this->upload_dir)) {
                return 'default.jpg';
            }
            $file_tmp = $file['image']['tmp_name'];
            $file_name = basename($file['image']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_ext)) {
                $new_file_name = 'product_' . uniqid('', true) . '.' . $file_ext;
                $target_path = $this->upload_dir . $new_file_name;
                if (move_uploaded_file($file_tmp, $target_path)) {
                    return $new_file_name;
                }
            }
        }
        return 'default.jpg';
    }

    private function deleteImage($id) {
        $product = $this->getById($id);
        if ($product && isset($product['image_url']) && $product['image_url'] != 'default.jpg') {
            $path = $this->upload_dir . $product['image_url'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
    
    // --- FUNGSI UNTUK FITUR LAIN (KERANJANG & DASHBOARD) ---

    public function getProductsByIds(array $ids) {
        if (empty($ids)) return [];
        $id_string = implode(',', array_map('intval', $ids));
        $query = "SELECT * FROM " . $this->table . " WHERE id IN (" . $id_string . ")";
        $result = mysqli_query($this->conn, $query);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }

    public function getTotalProducts() {
        $query = "SELECT COUNT(id) as total FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function getLowStockProductsCount($threshold = 10) {
        $query = "SELECT COUNT(id) as total FROM " . $this->table . " WHERE stock < " . (int)$threshold;
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}
?>
