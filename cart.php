<?php
require_once 'config/database.php';
include 'includes/header.php';

// Ambil data produk yang ada di keranjang
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        try {
            $product = $database->products->findOne(['_id' => new MongoDB\BSON\ObjectId($product_id)]);
            if ($product) {
                $cart_items[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        } catch (Exception $e) {
            error_log("Error fetching product: " . $e->getMessage());
        }
    }
}

// Hitung total belanja
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['product']->price * $item['quantity'];
}
?>

<div class="container mt-5">
    <div class="section-header">
        <h2>Keranjang Belanja</h2>
        <p class="text-muted">Review produk yang akan Anda beli</p>
    </div>

    <?php if (empty($cart_items)): ?>
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
        <h3>Keranjang Belanja Kosong</h3>
        <p class="text-muted">Anda belum menambahkan produk ke keranjang</p>
        <a href="products.php" class="btn btn-primary mt-3">
            <i class="fas fa-store me-2"></i>Lihat Produk
        </a>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item mb-3 pb-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="<?php echo htmlspecialchars($item['product']->image); ?>" 
                                     class="img-fluid rounded" 
                                     alt="<?php echo htmlspecialchars($item['product']->name); ?>">
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-1"><?php echo htmlspecialchars($item['product']->name); ?></h5>
                                <p class="text-muted mb-0">
                                    Rp <?php echo number_format($item['product']->price, 0, ',', '.'); ?>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group quantity-selector">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="updateQuantity('<?php echo $item['product']->_id; ?>', 'decrease')">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" 
                                           value="<?php echo $item['quantity']; ?>" min="1" 
                                           data-product-id="<?php echo $item['product']->_id; ?>"
                                           onchange="updateQuantity('<?php echo $item['product']->_id; ?>', 'set', this.value)">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="updateQuantity('<?php echo $item['product']->_id; ?>', 'increase')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="fw-bold">
                                    Rp <?php echo number_format($item['product']->price * $item['quantity'], 0, ',', '.'); ?>
                                </span>
                            </div>
                            <div class="col-md-1 text-end">
                                <button class="btn btn-link text-danger" 
                                        onclick="removeItem('<?php echo $item['product']->_id; ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga (<?php echo array_sum($_SESSION['cart']); ?> barang)</span>
                        <span class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total Tagihan</span>
                        <span class="fw-bold text-primary">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                    <button class="btn btn-primary w-100" onclick="window.location.href='checkout.php'">
                        <i class="fas fa-shopping-bag me-2"></i>Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.cart-item {
    transition: all 0.3s ease;
}

.cart-item:hover {
    background-color: var(--light-bg);
}

.quantity-selector {
    width: 120px;
}

.quantity-selector input {
    text-align: center;
}

.btn-link {
    text-decoration: none;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>

<script>
function updateQuantity(productId, action, value = 1) {
    let quantity = value;
    if (action === 'increase') {
        quantity = parseInt(document.querySelector(`input[data-product-id="${productId}"]`).value) + 1;
    } else if (action === 'decrease') {
        quantity = Math.max(1, parseInt(document.querySelector(`input[data-product-id="${productId}"]`).value) - 1);
    }

    fetch('cart-api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&action=update&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate keranjang');
    });
}

function removeItem(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        fetch('cart-api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&action=remove`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus produk');
        });
    }
}
</script>

<?php include 'includes/footer.php'; ?> 