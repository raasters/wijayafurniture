<?php
require_once 'config/database.php';
include 'includes/header.php';

// Cek jika keranjang kosong
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Ambil data produk di keranjang
$cart_items = [];
$total = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    try {
        $product = $database->products->findOne(['_id' => new MongoDB\BSON\ObjectId($product_id)]);
        if ($product) {
            $cart_items[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
            $total += $product->price * $quantity;
        }
    } catch (Exception $e) {
        error_log("Error fetching product: " . $e->getMessage());
    }
}

// Daftar metode pembayaran
$payment_methods = [
    'bni' => [
        'name' => 'Bank BNI',
        'account' => '1234567890',
        'holder' => 'PT Wijaya Furniture',
        'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png'
    ],
    'bri' => [
        'name' => 'Bank BRI',
        'account' => '0987654321',
        'holder' => 'PT Wijaya Furniture',
        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/2560px-BANK_BRI_logo.svg.png'
    ],
    'mandiri' => [
        'name' => 'Bank Mandiri',
        'account' => '2468135790',
        'holder' => 'PT Wijaya Furniture',
        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/2560px-Bank_Mandiri_logo_2016.svg.png'
    ],
    'bca' => [
        'name' => 'Bank BCA',
        'account' => '1357924680',
        'holder' => 'PT Wijaya Furniture',
        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png'
    ]
];

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);

    if ($name && $email && $phone && $address && $payment_method) {
        try {
            // Buat order baru
            $order = [
                'customer' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'notes' => $notes
                ],
                'items' => $cart_items,
                'total' => $total,
                'payment_method' => $payment_methods[$payment_method],
                'status' => 'pending',
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ];

            $result = $database->orders->insertOne($order);
            
            if ($result->getInsertedCount()) {
                // Kosongkan keranjang
                $_SESSION['cart'] = [];
                
                // Redirect ke halaman sukses
                header('Location: order-success.php?id=' . $result->getInsertedId());
                exit;
            }
        } catch (Exception $e) {
            $error = "Terjadi kesalahan saat memproses pesanan";
            error_log("Error creating order: " . $e->getMessage());
        }
    } else {
        $error = "Mohon lengkapi semua field yang diperlukan";
    }
}
?>

<div class="container mt-5">
    <div class="section-header text-center mb-5">
        <h2>Checkout</h2>
        <p class="text-muted">Lengkapi informasi pengiriman dan pembayaran</p>
    </div>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <!-- Form Pengiriman -->
            <div class="card mb-4 checkout-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="checkout-step">1</div>
                        <h5 class="card-title mb-0">Informasi Pengiriman</h5>
                    </div>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Tambahkan catatan untuk pesanan Anda"></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="payment-section">
                            <div class="d-flex align-items-center mb-4">
                                <div class="checkout-step">2</div>
                                <h5 class="mb-0">Metode Pembayaran</h5>
                            </div>
                            <?php foreach ($payment_methods as $code => $method): ?>
                            <div class="form-check payment-method-item mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_<?php echo $code; ?>" value="<?php echo $code; ?>" required>
                                <label class="form-check-label d-flex align-items-center" for="payment_<?php echo $code; ?>">
                                    <div class="payment-logo">
                                        <img src="<?php echo $method['logo']; ?>" alt="<?php echo $method['name']; ?>">
                                    </div>
                                    <span class="ms-3"><?php echo $method['name']; ?></span>
                                </label>
                                <div class="payment-details" id="details_<?php echo $code; ?>" style="display: none;">
                                    <div class="card bg-light border-0 mt-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>No. Rekening:</strong></p>
                                                    <h5 class="mb-3"><?php echo $method['account']; ?></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Atas Nama:</strong></p>
                                                    <h5 class="mb-0"><?php echo $method['holder']; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>Proses Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="col-md-4">
            <div class="card checkout-card sticky-top" style="top: 2rem;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                    <div class="order-items">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="order-item mb-3">
                            <div class="d-flex">
                                <img src="<?php echo htmlspecialchars($item['product']->image); ?>" 
                                     class="order-item-image me-3" 
                                     alt="<?php echo htmlspecialchars($item['product']->name); ?>">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($item['product']->name); ?></h6>
                                    <p class="text-muted mb-0">
                                        <?php echo $item['quantity']; ?> x Rp <?php echo number_format($item['product']->price, 0, ',', '.'); ?>
                                    </p>
                                </div>
                                <div class="ms-3 text-end">
                                    <span class="fw-bold">
                                        Rp <?php echo number_format($item['product']->price * $item['quantity'], 0, ',', '.'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Pengiriman</span>
                        <span class="badge bg-success">Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Total</h5>
                        <h5 class="text-primary mb-0">Rp <?php echo number_format($total, 0, ',', '.'); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Setelah detail pembayaran -->
<div class="alert alert-info mt-3">
    <div class="d-flex align-items-center mb-2">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Informasi Pembayaran:</strong>
    </div>
    <ol class="mb-0 ps-3">
        <li>Silakan transfer sejumlah <strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></li>
        <li>Setelah melakukan pembayaran, kirim bukti transfer ke WhatsApp kami:</li>
        <div class="d-flex align-items-center mt-2">
            <a href="https://wa.me/6282123456789" target="_blank" class="btn btn-success btn-sm">
                <i class="fab fa-whatsapp me-2"></i>Kirim Bukti Transfer (0821-2345-6789)
            </a>
        </div>
    </ol>
</div>

<div class="alert alert-warning mt-3">
    <i class="fas fa-clock me-2"></i>
    Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin kami.
</div>

<style>
.checkout-card {
    border: none;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    margin-bottom: 1.5rem;
}

.checkout-step {
    width: 30px;
    height: 30px;
    background-color: var(--secondary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 1rem;
}

.payment-method-item {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.payment-method-item:hover {
    border-color: var(--secondary-color);
    background-color: var(--light-bg);
}

.payment-logo {
    width: 80px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 5px;
    padding: 5px;
}

.payment-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.order-item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.form-control:focus {
    border-color: var(--secondary-color);
    box-shadow: 0 0 0 0.2rem rgba(162, 123, 92, 0.15);
}

.btn-primary {
    padding: 0.8rem 2rem;
    font-weight: 500;
}

.sticky-top {
    z-index: 1020;
}

@media (max-width: 768px) {
    .sticky-top {
        position: relative !important;
        top: 0 !important;
    }
}
</style>

<!-- Tambahkan script untuk toggle detail pembayaran -->
<script>
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Sembunyikan semua detail
        document.querySelectorAll('.payment-details').forEach(detail => {
            detail.style.display = 'none';
        });
        
        // Tampilkan detail yang dipilih
        if (this.checked) {
            document.getElementById('details_' + this.value).style.display = 'block';
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?> 