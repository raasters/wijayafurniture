<?php
require_once 'config/database.php';
include 'includes/header.php';

$order_id = $_GET['id'] ?? null;
$order = null;

if ($order_id) {
    try {
        $order = $database->orders->findOne(['_id' => new MongoDB\BSON\ObjectId($order_id)]);
    } catch (Exception $e) {
        error_log("Error fetching order: " . $e->getMessage());
    }
}

if (!$order) {
    header('Location: index.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <div class="success-icon mb-3">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2>Pesanan Berhasil!</h2>
        <p class="text-muted">Terima kasih telah berbelanja di Wijaya Furniture</p>
    </div>

    <div class="card order-success-card mx-auto">
        <div class="card-body p-4">
            <!-- Detail Pesanan -->
            <div class="order-details mb-4">
                <h5 class="section-title">Detail Pesanan</h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="detail-item">
                            <span class="label">Order ID:</span>
                            <span class="value"><?php echo $order->_id; ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="detail-item">
                            <span class="label">Nama:</span>
                            <span class="value"><?php echo htmlspecialchars($order->customer->name); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="detail-item">
                            <span class="label">Email:</span>
                            <span class="value"><?php echo htmlspecialchars($order->customer->email); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="detail-item">
                            <span class="label">Status:</span>
                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            <div class="payment-info">
                <h5 class="section-title">Informasi Pembayaran</h5>
                <div class="selected-bank mb-3">
                    <img src="<?php echo $order->payment_method['logo']; ?>" 
                         alt="<?php echo $order->payment_method['name']; ?>" 
                         height="30">
                    <strong class="ms-2"><?php echo $order->payment_method['name']; ?></strong>
                </div>

                <div class="bank-details mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="account-number">
                                <span class="label d-block">Nomor Rekening</span>
                                <span class="value"><?php echo $order->payment_method['account']; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="account-holder">
                                <span class="label d-block">Atas Nama</span>
                                <span class="value"><?php echo $order->payment_method['holder']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="total-payment text-center p-3 mb-4">
                    <span class="label d-block mb-2">Total Pembayaran</span>
                    <span class="amount">Rp <?php echo number_format($order->total, 0, ',', '.'); ?></span>
                </div>

                <div class="payment-steps">
                    <h6 class="steps-title mb-3">
                        <i class="fas fa-info-circle me-2"></i>Langkah Pembayaran:
                    </h6>
                    <ol class="steps-list">
                        <li>Transfer sejumlah <strong>Rp <?php echo number_format($order->total, 0, ',', '.'); ?></strong></li>
                        <li>Kirim bukti transfer melalui WhatsApp</li>
                    </ol>
                    <div class="whatsapp-button text-center mt-3">
                        <a href="https://wa.me/6282123456789?text=Halo, saya ingin konfirmasi pembayaran untuk Order ID: <?php echo $order->_id; ?>" 
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>Kirim Bukti Transfer
                        </a>
                    </div>
                </div>

                <div class="payment-note mt-4">
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin kami.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-primary">
            <i class="fas fa-home me-2"></i>Kembali ke Beranda
        </a>
    </div>
</div>

<style>
.success-icon {
    width: 80px;
    height: 80px;
    background: #28a745;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.success-icon i {
    font-size: 40px;
    color: white;
}

.order-success-card {
    max-width: 600px;
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 15px;
}

.section-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #eee;
}

.detail-item {
    margin-bottom: 0.5rem;
}

.detail-item .label {
    color: #666;
    margin-right: 0.5rem;
}

.detail-item .value {
    font-weight: 500;
}

.bank-details {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
}

.account-number, .account-holder {
    margin-bottom: 0.5rem;
}

.label {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}

.value {
    font-weight: 500;
    font-size: 1.1rem;
}

.total-payment {
    background: var(--light-bg);
    border-radius: 10px;
}

.total-payment .amount {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary-color);
}

.steps-list {
    padding-left: 1.2rem;
}

.steps-list li {
    margin-bottom: 0.8rem;
}

.whatsapp-button .btn {
    padding: 0.8rem 2rem;
    border-radius: 50px;
}

@media (max-width: 576px) {
    .order-success-card {
        margin: 0 1rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?> 