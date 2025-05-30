<?php
require_once 'config/database.php';
include 'includes/header.php';

// Mengambil parameter filter dan pencarian
$category = isset($_GET['category']) ? $_GET['category'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Menyiapkan filter untuk query
$filter = [];
if ($category) {
    // Cari kategori berdasarkan slug
    $cat = $database->categories->findOne(['slug' => $category]);
    if ($cat) {
        $filter['category_id'] = $cat->_id;
    }
}
if ($search) {
    $filter['$or'] = [
        ['name' => new MongoDB\BSON\Regex($search, 'i')],
        ['description' => new MongoDB\BSON\Regex($search, 'i')]
    ];
}

// Menyiapkan pengurutan
$sort_options = [
    'newest' => ['created_at' => -1],
    'price_low' => ['price' => 1],
    'price_high' => ['price' => -1],
    'name_asc' => ['name' => 1]
];

// Mengambil kategori untuk filter
$categories = $database->categories->find();

// Mengambil produk dengan filter dan pengurutan
$products = $database->products->find(
    $filter,
    ['sort' => $sort_options[$sort] ?? ['created_at' => -1]]
);
?>

<div class="container mt-5">
    <!-- Page Header -->
    <div class="section-header">
        <h2>Koleksi Furniture Kami</h2>
        <p class="text-muted">Temukan furniture berkualitas untuk melengkapi ruangan Anda</p>
    </div>

    <!-- Filter and Search Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="" method="GET" class="d-flex gap-3">
                <div class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..." 
                               value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat->_id; ?>" 
                                <?php echo ($category == $cat->_id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat->name); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        <div class="col-md-4">
            <select name="sort" class="form-select" onchange="window.location.href=this.value">
                <option value="?sort=newest" <?php echo ($sort == 'newest') ? 'selected' : ''; ?>>
                    Terbaru
                </option>
                <option value="?sort=price_low" <?php echo ($sort == 'price_low') ? 'selected' : ''; ?>>
                    Harga: Rendah ke Tinggi
                </option>
                <option value="?sort=price_high" <?php echo ($sort == 'price_high') ? 'selected' : ''; ?>>
                    Harga: Tinggi ke Rendah
                </option>
                <option value="?sort=name_asc" <?php echo ($sort == 'name_asc') ? 'selected' : ''; ?>>
                    Nama: A-Z
                </option>
            </select>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 product-card">
                <?php if($product->discount): ?>
                <div class="card-badge">
                    <span class="badge bg-danger">-<?php echo $product->discount; ?>%</span>
                </div>
                <?php endif; ?>
                
                <div class="product-image-wrapper">
                    <img src="<?php echo htmlspecialchars($product->image); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($product->name); ?>">
                    <div class="product-overlay">
                        <a href="product-detail.php?id=<?php echo $product->_id; ?>" 
                           class="btn btn-light btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product->name); ?></h5>
                    <p class="card-text text-muted mb-2">
                        <?php echo htmlspecialchars(substr($product->description, 0, 50)) . '...'; ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="price-wrapper">
                            <?php if($product->discount): ?>
                            <small class="text-muted text-decoration-line-through">
                                Rp <?php echo number_format($product->original_price, 0, ',', '.'); ?>
                            </small><br>
                            <?php endif; ?>
                            <span class="price">
                                Rp <?php echo number_format($product->price, 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm add-to-cart" 
                                    data-product-id="<?php echo $product->_id; ?>">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm wishlist-btn">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tambahkan Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-shopping-cart me-2"></i>
            <strong class="me-auto">Keranjang</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Produk berhasil ditambahkan ke keranjang
        </div>
    </div>
</div>

<!-- Tambahkan script untuk handle tambah ke keranjang -->
<script>
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const button = this;
        
        // Disable button sementara
        button.disabled = true;
        
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&action=add&quantity=1`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan toast notification
                const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                toast.show();
                
                // Update UI jika perlu
                console.log('Cart updated:', data.cart);
            } else {
                alert('Gagal menambahkan produk ke keranjang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan ke keranjang');
        })
        .finally(() => {
            // Enable button kembali
            button.disabled = false;
        });
    });
});
</script>

<style>
.product-card {
    position: relative;
    overflow: hidden;
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
}

.product-image-wrapper img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-card:hover .product-image-wrapper img {
    transform: scale(1.1);
}

.card-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
}

.price {
    color: var(--secondary-color);
    font-weight: 600;
    font-size: 1.1rem;
}

.add-to-cart {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.toast {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.toast-header {
    border-bottom: none;
    background: var(--light-bg);
    border-radius: 10px 10px 0 0;
}

.toast-body {
    padding: 1rem;
    color: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .col-md-3 {
        width: 50%;
    }
}

@media (max-width: 576px) {
    .col-md-3 {
        width: 100%;
    }
}
</style>

<?php include 'includes/footer.php'; ?> 