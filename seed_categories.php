<?php
require_once 'config/database.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seed Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Seeding Categories</h2>
        <div class="card">
            <div class="card-body">
                <?php
                // Hapus data kategori yang ada
                $database->categories->deleteMany([]);

                // Data kategori
                $categories = [
                    [
                        '_id' => new MongoDB\BSON\ObjectId(),
                        'name' => 'Sofa',
                        'slug' => 'sofa',
                        'description' => 'Koleksi sofa modern dan klasik'
                    ],
                    [
                        '_id' => new MongoDB\BSON\ObjectId(),
                        'name' => 'Meja',
                        'slug' => 'meja',
                        'description' => 'Berbagai jenis meja untuk rumah Anda'
                    ],
                    [
                        '_id' => new MongoDB\BSON\ObjectId(),
                        'name' => 'Kursi',
                        'slug' => 'kursi',
                        'description' => 'Kursi ergonomis dan stylish'
                    ],
                    [
                        '_id' => new MongoDB\BSON\ObjectId(),
                        'name' => 'Lemari',
                        'slug' => 'lemari',
                        'description' => 'Lemari pakaian dan penyimpanan'
                    ],
                    [
                        '_id' => new MongoDB\BSON\ObjectId(),
                        'name' => 'Workshop',
                        'slug' => 'workshop',
                        'description' => 'Layanan workshop dan custom furniture'
                    ]
                ];

                // Simpan ID kategori untuk digunakan di products
                $category_ids = [];
                foreach ($categories as $category) {
                    $category_ids[$category['slug']] = (string)$category['_id'];
                }

                // Masukkan data kategori
                try {
                    $result = $database->categories->insertMany($categories);
                    echo '<div class="alert alert-success">Berhasil menambahkan ' . $result->getInsertedCount() . ' kategori</div>';
                    
                    // Simpan ID kategori ke file
                    if (file_put_contents('category_ids.json', json_encode($category_ids))) {
                        echo '<div class="alert alert-info">File category_ids.json berhasil dibuat</div>';
                    } else {
                        echo '<div class="alert alert-danger">Gagal membuat file category_ids.json</div>';
                    }

                    // Tampilkan daftar kategori
                    echo '<h4>Kategori yang ditambahkan:</h4>';
                    echo '<ul class="list-group">';
                    foreach ($categories as $category) {
                        echo '<li class="list-group-item">
                            <h5>' . $category['name'] . '</h5>
                            <p class="mb-0">' . $category['description'] . '</p>
                        </li>';
                    }
                    echo '</ul>';
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                }
                ?>
                <div class="mt-4">
                    <a href="seed_products.php" class="btn btn-primary">Lanjut ke Seed Products</a>
                    <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 