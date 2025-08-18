<?php
// File: app/models/Product.php (VERSI FINAL DENGAN LOGIKA DESKRIPSI)

class Product
{
    private $conn;
    private $table = 'products';
    private $upload_dir;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->upload_dir = dirname(__DIR__, 2) . '/public/images/products/';
    }

    public function create($data, $files)
    {
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $kategori = mysqli_real_escape_string($this->conn, $data['kategori']);

        // --- INI BAGIAN YANG DIPERBAIKI ---
        $description = mysqli_real_escape_string($this->conn, $data['description'] ?? '');
        $short_description = mysqli_real_escape_string($this->conn, $data['short_description'] ?? ''); // Pastikan bumbunya diambil!

        $price = (int)$data['price'];
        $stock = (int)$data['stock'];
        $image_url = $this->handleImageSource($data, $files) ?? 'default.jpg';

        $query = "INSERT INTO " . $this->table . " (name, kategori, description, short_description, price, stock, image_url) VALUES ('$name', '$kategori', '$description', '$short_description', '$price', '$stock', '$image_url')";
        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data, $files)
    {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $kategori = mysqli_real_escape_string($this->conn, $data['kategori']);

        // --- INI BAGIAN YANG DIPERBAIKI ---
        $description = mysqli_real_escape_string($this->conn, $data['description'] ?? '');
        $short_description = mysqli_real_escape_string($this->conn, $data['short_description'] ?? ''); // Pastikan bumbunya diambil!

        $price = (int)$data['price'];
        $stock = (int)$data['stock'];
        $new_image_url = $this->handleImageSource($data, $files);

        $query = "UPDATE " . $this->table . " SET name = '$name', kategori = '$kategori', description = '$description', short_description = '$short_description', price = '$price', stock = '$stock'";
        if ($new_image_url) {
            $query .= ", image_url = '$new_image_url'";
        }
        $query .= " WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }


    public function getAll()
    {
        // Query ini sekarang mengambil jumlah produk terjual (total_sold)
        $query = "SELECT p.*, IFNULL(SUM(ti.quantity), 0) as total_sold
                  FROM " . $this->table . " p
                  LEFT JOIN transaction_items ti ON p.id = ti.product_id
                  GROUP BY p.id
                  ORDER BY p.id DESC";
        return mysqli_query($this->conn, $query);
    }

    // ==========================================================
    // MODIFIKASI FUNGSI INI JUGA
    // ==========================================================
    public function searchProducts($searchTerm)
    {
        $searchTerm = mysqli_real_escape_string($this->conn, $searchTerm);

        // Query pencarian juga di-upgrade untuk mengambil total_sold
        $query = "SELECT p.*, IFNULL(SUM(ti.quantity), 0) as total_sold
                  FROM " . $this->table . " p
                  LEFT JOIN transaction_items ti ON p.id = ti.product_id
                  WHERE p.name LIKE '%" . $searchTerm . "%' OR p.description LIKE '%" . $searchTerm . "%'
                  GROUP BY p.id
                  ORDER BY p.id DESC";

        return mysqli_query($this->conn, $query);
    }

    public function getById($id)
    {
        $id = (int)$id;

        // Query super canggih untuk mengambil data produk, rata-rata rating, jumlah ulasan, dan jumlah terjual sekaligus!
        $query = "
        SELECT 
            p.*, 
            IFNULL(AVG(pr.rating), 0) as avg_rating, 
            COUNT(DISTINCT pr.id) as review_count,
            IFNULL(SUM(ti.quantity), 0) as total_sold
        FROM 
            products p
        LEFT JOIN 
            product_reviews pr ON p.id = pr.product_id
        LEFT JOIN 
            transaction_items ti ON p.id = ti.product_id
        WHERE 
            p.id = ?
        GROUP BY 
            p.id
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function delete($id)
    {
        $id = (int)$id;
        $this->deleteImage($id);
        $query = "DELETE FROM " . $this->table . " WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }

    private function handleImageSource($data, $files)
    {
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0777, true);
        }
        if (isset($data['image_source']) && $data['image_source'] === 'url' && !empty($data['image_url'])) {
            $url = $data['image_url'];
            $imageContent = @file_get_contents($url);
            if ($imageContent === false) {
                return null;
            }
            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $new_file_name = 'product_' . uniqid('', true) . '.' . $ext;
            if (file_put_contents($this->upload_dir . $new_file_name, $imageContent)) {
                return $new_file_name;
            }
        } elseif (isset($data['image_source']) && $data['image_source'] === 'upload' && isset($files['image_file']) && $files['image_file']['error'] === UPLOAD_ERR_OK) {
            return $this->uploadImage($files);
        }
        return null;
    }

    private function uploadImage($files)
    {
        $file_tmp = $files['image_file']['tmp_name'];
        $file_name = basename($files['image_file']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = 'product_' . uniqid('', true) . '.' . $file_ext;
            if (move_uploaded_file($file_tmp, $this->upload_dir . $new_file_name)) {
                return $new_file_name;
            }
        }
        return 'default.jpg';
    }

    private function deleteImage($id)
    {
        $product = $this->getById($id);
        if ($product && isset($product['image_url']) && $product['image_url'] != 'default.jpg') {
            $path = $this->upload_dir . $product['image_url'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function getProductsByIds(array $ids)
    {
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

    public function getTotalProducts()
    {
        $query = "SELECT COUNT(id) as total FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function getLowStockProductsCount($threshold = 10)
    {
        $query = "SELECT COUNT(id) as total FROM " . $this->table . " WHERE stock < " . (int)$threshold;
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}
