<?php
// File: test_upload.php (Alat Pelacak Sederhana)

// Atur folder tujuan upload
$target_dir = "uploads/";

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo "<h1>Hasil Pelacakan:</h1>";
    echo "<hr>";

    // Cek apakah ada file yang dipilih
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        
        echo "<b>Informasi File:</b><br>";
        echo "<pre>";
        print_r($_FILES["gambar"]);
        echo "</pre>";
        echo "<hr>";
        
        echo "<b>Mencoba memindahkan file ke:</b> " . $target_file . "<br>";

        // Coba pindahkan file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "<h2 style='color:green;'>BERHASIL! Gambar berhasil di-upload!</h2>";
            echo "Silakan cek folder 'uploads', gambar kamu seharusnya ada di sana.<br>";
            echo "<img src='" . $target_file . "' width='200'>";
        } else {
            echo "<h2 style='color:red;'>GAGAL! Tidak bisa memindahkan file.</h2>";
            echo "Ini kemungkinan besar masalah **IZIN FOLDER (Permission)**. Pastikan folder 'uploads' sudah kamu setting security-nya.";
        }

    } else {
        echo "<h2 style='color:red;'>ERROR! Kamu tidak memilih gambar atau ada kesalahan lain.</h2>";
        echo "<b>Error code:</b> " . $_FILES["gambar"]["error"];
    }

    echo "<hr><a href='test_upload.php'>Coba Lagi</a>";

} else {
    // Tampilkan form upload jika belum disubmit
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Tes Upload Gambar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="p-5">
        <div class="container card p-4">
            <h2>Alat Pelacak Gambar Hilang</h2>
            <p>Pilih sebuah gambar lalu klik tombol "Lacak Sekarang!"</p>
            <form action="test_upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="gambar" class="form-label">Pilih Gambar:</label>
                    <input type="file" class="form-control" name="gambar" id="gambar">
                </div>
                <button type="submit" class="btn btn-primary">Lacak Sekarang!</button>
            </form>
        </div>
    </body>
    </html>
<?php
}
?>