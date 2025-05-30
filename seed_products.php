<?php
require_once 'config/database.php';

// Set header untuk menampilkan output sebagai HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seed Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Seeding Database</h2>
        <div class="card">
            <div class="card-body">
                <?php
                // Ambil kategori dari database
                $categories = $database->categories->find();
                $category_ids = [];
                
                // Buat array category_ids dari data database
                foreach ($categories as $category) {
                    $category_ids[$category->slug] = $category->_id;
                }

                if (empty($category_ids)) {
                    echo '<div class="alert alert-danger">Error: Kategori belum dibuat. Silakan jalankan seed_categories.php terlebih dahulu.</div>';
                    echo '<div class="mt-4">
                            <a href="seed_categories.php" class="btn btn-primary">Buat Kategori</a>
                            <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
                          </div>';
                    exit;
                }

                // Hapus data produk yang ada
                $database->products->deleteMany([]);

                // Data produk contoh
                $products = [
                    [
                        'name' => 'Sofa Modern 3 Seater',
                        'description' => 'Sofa modern dengan bahan premium dan kenyamanan maksimal',
                        'price' => 5999000,
                        'original_price' => 7499000,
                        'discount' => 20,
                        'image' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 10,
                        'created_at' => new MongoDB\BSON\UTCDateTime()
                    ],
                    [
                        'name' => 'Meja Makan Minimalis',
                        'description' => 'Meja makan kayu solid dengan desain minimalis modern',
                        'price' => 4299000,
                        'original_price' => 4299000,
                        'discount' => 0,
                        'image' => 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime()
                    ],
                    [
                        'name' => 'Kursi Kerja Ergonomis',
                        'description' => 'Kursi kerja dengan desain ergonomis untuk kenyamanan bekerja',
                        'price' => 1999000,
                        'original_price' => 2499000,
                        'discount' => 20,
                        'image' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['kursi'],
                        'stock' => 15,
                        'created_at' => new MongoDB\BSON\UTCDateTime()
                    ],
                    [
                        'name' => 'Lemari Pakaian Modern',
                        'description' => 'Lemari pakaian 3 pintu dengan desain modern dan spacious',
                        'price' => 3799000,
                        'original_price' => 4499000,
                        'discount' => 15,
                        'image' => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 8,
                        'created_at' => new MongoDB\BSON\UTCDateTime()
                    ],
                    // Tambahan produk workshop
                    [
                        'name' => 'Workshop Custom Furniture',
                        'description' => 'Layanan pembuatan furniture custom sesuai kebutuhan Anda',
                        'price' => 0, // Harga menyesuaikan project
                        'original_price' => 0,
                        'discount' => 0,
                        'image' => 'https://images.unsplash.com/photo-1580130037321-446dba3cacc0?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['workshop'],
                        'stock' => 999,
                        'created_at' => new MongoDB\BSON\UTCDateTime()
                    ],
                    // Produk Ekspor - Malaysia
                    [
                        'name' => 'Teak Wood Dining Set',
                        'description' => 'Set meja makan dari kayu jati berkualitas tinggi dengan 6 kursi, cocok untuk dining room mewah',
                        'price' => 15999000,
                        'original_price' => 18999000,
                        'discount' => 15,
                        'image' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 8,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Malaysia',
                        'export_details' => [
                            'country' => 'Malaysia',
                            'certification' => 'MTTC Certified',
                            'shipping_method' => 'Sea Freight'
                        ]
                    ],
                    // Produk Ekspor - Amerika
                    [
                        'name' => 'Modern Rattan Collection',
                        'description' => 'Set furniture rotan modern terdiri dari sofa, coffee table, dan side table dengan desain kontemporer',
                        'price' => 28999000,
                        'original_price' => 32999000,
                        'discount' => 12,
                        'image' => 'https://images.unsplash.com/photo-1540638349517-3abd5afc5847?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'United States',
                        'export_details' => [
                            'country' => 'United States',
                            'certification' => 'FDA Compliant, ASTM Certified',
                            'shipping_method' => 'Container Shipping'
                        ]
                    ],
                    // Produk Ekspor - Australia
                    [
                        'name' => 'Reclaimed Wood Bedroom Set',
                        'description' => 'Set kamar tidur dari kayu reklamasi dengan finishing natural, ramah lingkungan dan tahan lama',
                        'price' => 24999000,
                        'original_price' => 27999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1505693314120-0d443867891c?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 3,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Australia',
                        'export_details' => [
                            'country' => 'Australia',
                            'certification' => 'Australian Standards Certified',
                            'shipping_method' => 'Sea Freight'
                        ]
                    ],
                    // Produk Ekspor - Jepang
                    [
                        'name' => 'Minimalist Zen Office Set',
                        'description' => 'Set furniture kantor dengan desain minimalis zen, terdiri dari meja kerja, kursi, dan rak penyimpanan',
                        'price' => 21999000,
                        'original_price' => 24999000,
                        'discount' => 12,
                        'image' => 'https://images.unsplash.com/photo-1519974719765-e6559eac2575?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['kursi'],
                        'stock' => 6,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Japan',
                        'export_details' => [
                            'country' => 'Japan',
                            'certification' => 'JIS Certified',
                            'shipping_method' => 'Sea Freight'
                        ]
                    ],
                    // Produk Ekspor Premium - Multi Country
                    [
                        'name' => 'Luxury Teak Living Room Collection',
                        'description' => 'Koleksi ruang tamu mewah dari kayu jati grade A dengan ukiran tradisional modern',
                        'price' => 45999000,
                        'original_price' => 52999000,
                        'discount' => 13,
                        'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 4,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => ['Malaysia', 'United States', 'Australia', 'Japan'],
                        'export_details' => [
                            'certification' => ['MTTC', 'ASTM', 'AS', 'JIS'],
                            'shipping_method' => 'Premium Container Service',
                            'insurance' => 'Full Coverage International Shipping Insurance'
                        ]
                    ]
                ];

                // Data produk ekspor tambahan
                $export_products = [
                    // Produk Ekspor Malaysia
                    [
                        'name' => 'Premium Teak Dining Set',
                        'description' => 'Set meja makan premium dari kayu jati grade A dengan 8 kursi, finishing natural oil treatment',
                        'price' => 25999000,
                        'original_price' => 28999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1615066390971-03e4e1c36ddf?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Malaysia',
                        'export_details' => [
                            'country' => 'Malaysia',
                            'certification' => 'MTTC Certified',
                            'shipping_method' => 'Premium Container'
                        ]
                    ],
                    [
                        'name' => 'Executive Office Set',
                        'description' => 'Set furniture kantor eksekutif lengkap dengan meja direktur, credenza, dan lemari arsip',
                        'short_desc' => 'Premium office furniture set',
                        'price' => 32999000,
                        'original_price' => 35999000,
                        'discount' => 8,
                        'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 3,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Malaysia',
                        'export_details' => [
                            'country' => 'Malaysia',
                            'certification' => 'MTTC Certified',
                            'shipping_method' => 'Door-to-Door Service'
                        ]
                    ],

                    // Produk Ekspor Amerika
                    [
                        'name' => 'Contemporary Living Room Set',
                        'description' => 'Set ruang tamu kontemporer dengan sofa 3-2-1, coffee table, dan side table dari kayu mahoni',
                        'price' => 42999000,
                        'original_price' => 47999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1605774337664-7a846e9cdf17?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 4,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'United States',
                        'export_details' => [
                            'country' => 'United States',
                            'certification' => 'ASTM Certified, EPA Compliant',
                            'shipping_method' => 'Premium Container'
                        ]
                    ],
                    [
                        'name' => 'Luxury Bedroom Collection',
                        'description' => 'Koleksi kamar tidur mewah dengan king bed, 2 nakas, dresser, dan lemari pakaian 4 pintu',
                        'price' => 55999000,
                        'original_price' => 62999000,
                        'discount' => 11,
                        'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 2,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'United States',
                        'export_details' => [
                            'country' => 'United States',
                            'certification' => 'ASTM Certified, CARB Compliant',
                            'shipping_method' => 'White Glove Delivery'
                        ]
                    ],

                    // Produk Ekspor Australia
                    [
                        'name' => 'Eco-Friendly Outdoor Set',
                        'description' => 'Set furniture outdoor dari kayu jati reclaimed dengan treatment tahan cuaca',
                        'price' => 28999000,
                        'original_price' => 31999000,
                        'discount' => 9,
                        'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 6,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Australia',
                        'export_details' => [
                            'country' => 'Australia',
                            'certification' => 'AS/NZS Standards, FSC Certified',
                            'shipping_method' => 'Container Shipping'
                        ]
                    ],
                    [
                        'name' => 'Modern Kitchen Cabinet Set',
                        'description' => 'Set kabinet dapur modern dengan material ramah lingkungan dan hardware premium',
                        'price' => 35999000,
                        'original_price' => 39999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 4,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Australia',
                        'export_details' => [
                            'country' => 'Australia',
                            'certification' => 'AS/NZS Standards, Green Tag Certified',
                            'shipping_method' => 'Custom Installation Service'
                        ]
                    ],

                    // Produk Ekspor Jepang
                    [
                        'name' => 'Zen Home Office Collection',
                        'description' => 'Koleksi home office dengan desain zen minimalis, ergonomis dan fungsional',
                        'price' => 27999000,
                        'original_price' => 30999000,
                        'discount' => 9,
                        'image' => 'https://images.unsplash.com/photo-1585634917202-6f03b28fc6d0?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 7,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Japan',
                        'export_details' => [
                            'country' => 'Japan',
                            'certification' => 'JIS Certified, F☆☆☆☆ Standard',
                            'shipping_method' => 'Express Container Service'
                        ]
                    ],
                    [
                        'name' => 'Tatami Style Living Set',
                        'description' => 'Set ruang keluarga bergaya tatami modern dengan material alami dan finishing premium',
                        'price' => 33999000,
                        'original_price' => 37999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Japan',
                        'export_details' => [
                            'country' => 'Japan',
                            'certification' => 'JIS Certified, Eco Mark',
                            'shipping_method' => 'White Glove Delivery'
                        ]
                    ]
                ];

                // Tambahan produk ekspor
                $additional_export_products = [
                    // Malaysia - Produk Tambahan
                    [
                        'name' => 'Royal Teak Bedroom Set',
                        'description' => 'Set kamar tidur mewah dengan ukiran tradisional Jepara, terdiri dari tempat tidur king size, 2 nakas, dan lemari 6 pintu',
                        'price' => 38999000,
                        'original_price' => 42999000,
                        'discount' => 9,
                        'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 3,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Malaysia',
                        'export_details' => [
                            'country' => 'Malaysia',
                            'certification' => 'MTTC Certified',
                            'shipping_method' => 'Premium Delivery'
                        ]
                    ],
                    [
                        'name' => 'Islamic Geometric Cabinet',
                        'description' => 'Lemari hias dengan motif geometris Islam, cocok untuk ruang tamu atau ruang keluarga modern',
                        'price' => 15999000,
                        'original_price' => 17999000,
                        'discount' => 11,
                        'image' => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Malaysia',
                        'export_details' => [
                            'country' => 'Malaysia',
                            'certification' => 'MTTC Certified',
                            'shipping_method' => 'Express Shipping'
                        ]
                    ],

                    // Amerika - Produk Tambahan
                    [
                        'name' => 'Industrial Loft Collection',
                        'description' => 'Koleksi furniture bergaya industrial loft, kombinasi kayu jati dan besi tempa',
                        'price' => 35999000,
                        'original_price' => 39999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 4,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'United States',
                        'export_details' => [
                            'country' => 'United States',
                            'certification' => 'ASTM Certified',
                            'shipping_method' => 'Container Shipping'
                        ]
                    ],
                    [
                        'name' => 'Mid-Century Modern Set',
                        'description' => 'Set ruang keluarga bergaya mid-century modern dengan bahan premium dan detail klasik',
                        'price' => 42999000,
                        'original_price' => 47999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1554295405-abb8fd54f153?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 3,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'United States',
                        'export_details' => [
                            'country' => 'United States',
                            'certification' => 'ASTM Certified',
                            'shipping_method' => 'White Glove Delivery'
                        ]
                    ],

                    // Australia - Produk Tambahan
                    [
                        'name' => 'Sustainable Bamboo Collection',
                        'description' => 'Koleksi furniture ramah lingkungan dari bambu dengan sertifikasi FSC',
                        'price' => 28999000,
                        'original_price' => 31999000,
                        'discount' => 9,
                        'image' => 'https://images.unsplash.com/photo-1617104551722-3b2d51366400?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 6,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Australia',
                        'export_details' => [
                            'country' => 'Australia',
                            'certification' => 'AS/NZS Standards, FSC Certified',
                            'shipping_method' => 'Eco-friendly Shipping'
                        ]
                    ],
                    [
                        'name' => 'Coastal Living Collection',
                        'description' => 'Set furniture bergaya pantai dengan finishing tahan cuaca dan air laut',
                        'price' => 33999000,
                        'original_price' => 36999000,
                        'discount' => 8,
                        'image' => 'https://images.unsplash.com/photo-1505693314120-0d443867891c?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['sofa'],
                        'stock' => 4,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Australia',
                        'export_details' => [
                            'country' => 'Australia',
                            'certification' => 'AS/NZS Standards',
                            'shipping_method' => 'Marine-grade Container'
                        ]
                    ],

                    // Jepang - Produk Tambahan
                    [
                        'name' => 'Minimalist Tea Room Set',
                        'description' => 'Set ruang teh tradisional dengan sentuhan minimalis modern, termasuk meja pendek dan bantalan lantai',
                        'price' => 18999000,
                        'original_price' => 20999000,
                        'discount' => 9,
                        'image' => 'https://images.unsplash.com/photo-1590361232060-61b9a025a068?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['meja'],
                        'stock' => 5,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Japan',
                        'export_details' => [
                            'country' => 'Japan',
                            'certification' => 'JIS Certified',
                            'shipping_method' => 'Premium Air Freight'
                        ]
                    ],
                    [
                        'name' => 'Compact Living Solution',
                        'description' => 'Sistem furniture modular untuk apartemen kecil dengan fungsi penyimpanan maksimal',
                        'price' => 25999000,
                        'original_price' => 28999000,
                        'discount' => 10,
                        'image' => 'https://images.unsplash.com/photo-1591129841117-3adfd313e34f?auto=format&fit=crop&w=800&q=80',
                        'featured' => true,
                        'category_id' => $category_ids['lemari'],
                        'stock' => 6,
                        'created_at' => new MongoDB\BSON\UTCDateTime(),
                        'export_to' => 'Japan',
                        'export_details' => [
                            'country' => 'Japan',
                            'certification' => 'JIS Certified, F☆☆☆☆ Standard',
                            'shipping_method' => 'Container with Humidity Control'
                        ]
                    ]
                ];

                // Gabungkan dengan array produk yang sudah ada
                $products = array_merge($products, $export_products, $additional_export_products);

                // Masukkan data produk
                try {
                    $result = $database->products->insertMany($products);
                    echo '<div class="alert alert-success">Berhasil menambahkan ' . $result->getInsertedCount() . ' produk</div>';
                    
                    // Tampilkan daftar produk yang ditambahkan
                    echo '<h4>Produk yang ditambahkan:</h4>';
                    echo '<ul class="list-group">';
                    foreach ($products as $product) {
                        echo '<li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="' . $product['image'] . '" class="img-fluid rounded" alt="' . $product['name'] . '">
                                </div>
                                <div class="col-md-10">
                                    <h5>' . $product['name'] . '</h5>
                                    <p class="mb-1">' . $product['description'] . '</p>
                                    <p class="mb-0">Harga: Rp ' . number_format($product['price'], 0, ',', '.') . '</p>
                                </div>
                            </div>
                        </li>';
                    }
                    echo '</ul>';
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                }
                ?>
                <div class="mt-4">
                    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 