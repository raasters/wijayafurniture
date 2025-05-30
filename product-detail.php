<?php
require_once 'config/database.php';
include 'includes/header.php';

// Mengambil ID produk dari URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$product_id) {
    header('Location: products.php');
    exit;
}

// Mengambil detail produk
try {
    $product = $database->products->findOne(['_id' => new MongoDB\BSON\ObjectId($product_id)]);
    if (!$product) {
        header('Location: products.php');
        exit;
    }
    
    // Mengambil produk terkait dari kategori yang sama
    $related_products = $database->products->find([
        'category_id' => $product->category_id,
        '_id' => ['$ne' => new MongoDB\BSON\ObjectId($product_id)]
    ], ['limit' => 4]);
} catch (Exception $e) {
    header('Location: products.php');
    exit;
}
?>

<div class="container mt-5">
    <!-- Product Detail -->
    <div class="row">
        <div class="col-md-6">
            <div class="product-image-container">
                <?php if($product->discount): ?>
                <span class="badge bg-danger discount-badge">-<?php echo $product->discount; ?>%</span>
                <?php endif; ?>
                <img src="<?php echo htmlspecialchars($product->image); ?>" 
                     class="img-fluid rounded product-main-image" 
                     alt="<?php echo htmlspecialchars($product->name); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="products.php">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product->name); ?></li>
                </ol>
            </nav>
            
            <h1 class="product-title"><?php echo htmlspecialchars($product->name); ?></h1>
            
            <div class="price-section mb-4">
                <?php if($product->discount): ?>
                <span class="original-price">Rp <?php echo number_format($product->original_price, 0, ',', '.'); ?></span>
                <?php endif; ?>
                <span class="current-price">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></span>
            </div>
            
            <div class="product-description mb-4">
                <h5>Deskripsi Produk</h5>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($product->description)); ?></p>
            </div>
            
            <div class="product-meta mb-4">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Kategori</small>
                        <p><?php echo htmlspecialchars($product->category_id); ?></p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Stok</small>
                        <p><?php echo $product->stock > 0 ? 'Tersedia (' . $product->stock . ')' : 'Habis'; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="product-actions">
                <div class="row g-2">
                    <div class="col-auto">
                        <div class="input-group quantity-selector">
                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?php echo $product->stock; ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100" onclick="addToCart('<?php echo $product->_id; ?>')">
                            <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-secondary wishlist-btn">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <section class="related-products mt-5">
        <h3 class="section-title mb-4">Produk Terkait</h3>
        <div class="row">
            <?php foreach ($related_products as $related): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 product-card">
                    <?php if($related->discount): ?>
                    <div class="card-badge">
                        <span class="badge bg-danger">-<?php echo $related->discount; ?>%</span>
                    </div>
                    <?php endif; ?>
                    
                    <img src="<?php echo htmlspecialchars($related->image); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($related->name); ?>">
                         
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($related->name); ?></h5>
                        <p class="card-text">Rp <?php echo number_format($related->price, 0, ',', '.'); ?></p>
                        <a href="product-detail.php?id=<?php echo $related->_id; ?>" class="btn btn-outline-primary">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<style>
.product-image-container {
    position: relative;
    margin-bottom: 2rem;
}

.product-main-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.discount-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    font-size: 1.1rem;
}

.product-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.price-section {
    margin-bottom: 1.5rem;
}

.original-price {
    color: #999;
    text-decoration: line-through;
    font-size: 1.1rem;
    margin-right: 1rem;
}

.current-price {
    color: var(--secondary-color);
    font-size: 1.8rem;
    font-weight: 600;
}

.quantity-selector {
    width: 120px;
}

.quantity-selector input {
    text-align: center;
}

.quantity-selector .btn {
    padding: 0.375rem 0.75rem;
}

.wishlist-btn {
    width: 46px;
    height: 46px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.breadcrumb {
    margin-bottom: 2rem;
}

.breadcrumb a {
    color: var(--secondary-color);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.section-title {
    color: var(--primary-color);
    position: relative;
    padding-bottom: 0.5rem;
    margin-bottom: 2rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--secondary-color);
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
}
</style>

<script>
function updateQuantity(change) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    const newValue = currentValue + change;
    
    if (newValue >= 1 && newValue <= maxValue) {
        input.value = newValue;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    fetch('cart-api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&action=add&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tampilkan notifikasi sukses
            const toast = new bootstrap.Toast(document.getElementById('cartToast'));
            toast.show();
            
            // Update jumlah item di keranjang di navbar
            const cartBadge = document.querySelector('.nav-link .badge');
            if (cartBadge) {
                const totalItems = Object.values(data.cart).reduce((a, b) => a + b, 0);
                cartBadge.textContent = totalItems;
            }
        } else {
            alert('Gagal menambahkan produk ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan ke keranjang');
    });
}
</script>

<!-- Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-shopping-cart me-2"></i>
            <strong class="me-auto">Keranjang</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success me-2"></i>
                Produk berhasil ditambahkan ke keranjang
            </div>
            <div class="mt-2 pt-2 border-top">
                <a href="cart.php" class="btn btn-primary btn-sm">Lihat Keranjang</a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">
                    Lanjut Belanja
                </button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 