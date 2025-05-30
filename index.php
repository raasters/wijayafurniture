<?php
require_once 'config/database.php';
include 'includes/header.php';

// Mengambil produk unggulan
$featured_products = $database->products->find(
    ['featured' => true],
    ['limit' => 4]
);
?>

<div class="hero-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" 
         data-bs-ride="carousel" 
         data-bs-interval="6000" 
         data-bs-pause="false" 
         data-bs-touch="true">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="jumbotron text-center" style="background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1920&q=80');">
                    <div class="container">
                        <h1 class="display-4">Elegance in Every Detail</h1>
                        <p class="lead">Temukan koleksi furniture berkualitas yang menghadirkan keindahan dan kenyamanan untuk rumah impian Anda</p>
                        <a href="products.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Jelajahi Koleksi Kami
                        </a>
                    </div>
                </div>
                <div class="wave-container">
                    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.2)" />
                            <use xlink:href="#gentle-wave" x="48" y="2" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="4" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="jumbotron text-center" style="background-image: url('https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=1920&q=80');">
                    <div class="container">
                        <h1 class="display-4">Modern Living Space</h1>
                        <p class="lead">Desain modern untuk ruang keluarga yang nyaman dan elegan</p>
                        <a href="products.php?category=sofa" class="btn btn-primary btn-lg">
                            <i class="fas fa-couch me-2"></i>Koleksi Sofa
                        </a>
                    </div>
                </div>
                <div class="wave-container">
                    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.2)" />
                            <use xlink:href="#gentle-wave" x="48" y="2" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="4" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="jumbotron text-center" style="background-image: url('https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?auto=format&fit=crop&w=1920&q=80');">
                    <div class="container">
                        <h1 class="display-4">Dining Excellence</h1>
                        <p class="lead">Ciptakan momen berharga bersama keluarga dengan koleksi meja makan kami</p>
                        <a href="products.php?category=meja" class="btn btn-primary btn-lg">
                            <i class="fas fa-utensils me-2"></i>Koleksi Meja
                        </a>
                    </div>
                </div>
                <div class="wave-container">
                    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.2)" />
                            <use xlink:href="#gentle-wave" x="48" y="2" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="4" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-5">
    <!-- Featured Products -->
    <section class="featured-products">
        <div class="section-header">
            <h2>Produk Unggulan</h2>
            <p class="text-muted">Pilihan terbaik untuk melengkapi ruangan Anda</p>
        </div>
        
        <div class="row">
            <?php foreach ($featured_products as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-badge">
                        <?php if($product->discount): ?>
                            <span class="badge bg-danger">-<?php echo $product->discount; ?>%</span>
                        <?php endif; ?>
                    </div>
                    <img src="<?php echo $product->image; ?>" class="card-img-top" alt="<?php echo $product->name; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product->name; ?></h5>
                        <p class="card-text">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="product-detail.php?id=<?php echo $product->_id; ?>" class="btn btn-primary">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Export Products -->
    <section class="export-products mt-5">
        <div class="section-header">
            <h2>Produk Ekspor Unggulan</h2>
            <p class="text-muted">Kualitas Internasional dari Indonesia untuk Dunia</p>
        </div>
        
        <!-- Export Destinations -->
        <div class="export-destinations mb-5">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="destination-badge">
                        <i class="fas fa-globe-asia"></i>
                        <h5>Malaysia</h5>
                        <span class="badge bg-success">MTTC Certified</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="destination-badge">
                        <i class="fas fa-globe-americas"></i>
                        <h5>United States</h5>
                        <span class="badge bg-success">ASTM Certified</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="destination-badge">
                        <i class="fas fa-globe-oceania"></i>
                        <h5>Australia</h5>
                        <span class="badge bg-success">AS Certified</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="destination-badge">
                        <i class="fas fa-globe-asia"></i>
                        <h5>Japan</h5>
                        <span class="badge bg-success">JIS Certified</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Export Products By Country -->
        <?php
        $export_countries = ['Malaysia', 'United States', 'Australia', 'Japan'];
        
        foreach ($export_countries as $country):
            // Debug untuk melihat query
            /*
            echo '<pre>';
            var_dump([
                'country' => $country,
                'query' => [
                    'export_to' => $country,
                    'featured' => true
                ]
            ]);
            echo '</pre>';
            */

            $country_products = $database->products->find([
                'export_to' => $country,
                'featured' => true
            ], [
                'sort' => ['created_at' => -1],
                'limit' => 4
            ]);
            
            // Convert cursor to array and check if empty
            $products_array = iterator_to_array($country_products);
            if (empty($products_array)) continue;
        ?>
        <div class="country-export-section mb-5">
            <div class="d-flex align-items-center mb-4">
                <h3 class="mb-0"><?php echo $country; ?></h3>
                <div class="certification-badge ms-3">
                    <?php
                    $cert = [
                        'Malaysia' => 'MTTC',
                        'United States' => 'ASTM',
                        'Australia' => 'AS/NZS',
                        'Japan' => 'JIS'
                    ][$country];
                    ?>
                    <span class="badge bg-success">
                        <i class="fas fa-certificate me-1"></i>
                        <?php echo $cert; ?> Certified
                    </span>
                </div>
            </div>
            
            <div class="row">
            <?php foreach ($products_array as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 export-card">
                        <?php if(isset($product['discount']) && $product['discount']): ?>
                        <div class="card-badge">
                            <span class="badge bg-danger">-<?php echo $product['discount']; ?>%</span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="export-country mb-2">
                            <span class="badge bg-primary"><?php echo $country; ?></span>
                        </div>
                        
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price-wrapper">
                                    <?php if(isset($product['discount']) && $product['discount']): ?>
                                    <small class="text-muted text-decoration-line-through">
                                        Rp <?php echo number_format($product['original_price'], 0, ',', '.'); ?>
                                    </small><br>
                                    <?php endif; ?>
                                    <span class="price">
                                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                                    </span>
                                </div>
                                <a href="product-detail.php?id=<?php echo $product['_id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </section>

    <!-- Customer Reviews Section -->
    <section class="reviews-section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Apa Kata Mereka?</h2>
                <p class="text-muted">Testimoni dari pelanggan setia kami</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-content">
                            <div class="stars mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">"Kualitas furniturnya luar biasa bagus. Saya membeli set kursi makan, dan hasilnya melebihi ekspektasi. Pengerjaan detailnya sangat rapi, khas ukiran Jepara."</p>
                            <div class="reviewer-info d-flex align-items-center mt-4">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="reviewer" class="reviewer-img">
                                <div class="ms-3">
                                    <h5 class="mb-0">Ahmad Ridwan</h5>
                                    <small class="text-muted">Jakarta</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-content">
                            <div class="stars mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">"Pelayanannya sangat memuaskan. Tim Wijaya Furniture sangat membantu dalam memilih furniture yang sesuai dengan kebutuhan dan budget. Pengiriman juga tepat waktu."</p>
                            <div class="reviewer-info d-flex align-items-center mt-4">
                                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="reviewer" class="reviewer-img">
                                <div class="ms-3">
                                    <h5 class="mb-0">Siti Aminah</h5>
                                    <small class="text-muted">Surabaya</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-content">
                            <div class="stars mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="review-text">"Desain furniturenya sangat modern namun tetap mempertahankan sentuhan klasik ukiran Jepara. Cocok untuk rumah minimalis modern. Harga sebanding dengan kualitas."</p>
                            <div class="reviewer-info d-flex align-items-center mt-4">
                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="reviewer" class="reviewer-img">
                                <div class="ms-3">
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <small class="text-muted">Bandung</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.review-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.review-card:hover {
    transform: translateY(-10px);
}

.stars {
    color: #ffc107;
}

.review-text {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #666;
    margin-bottom: 0;
}

.reviewer-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.reviewer-info h5 {
    font-size: 1rem;
    color: var(--primary-color);
}

.reviewer-info small {
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .review-card {
        margin-bottom: 1.5rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?> 