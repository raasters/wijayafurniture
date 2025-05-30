<?php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process contact form
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message_text = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if ($name && $email && $subject && $message_text) {
        $contact = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message_text,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ];

        try {
            $database->messages->insertOne($contact);
            $message = '<div class="alert alert-success">Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.</div>';
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">Maaf, terjadi kesalahan. Silakan coba lagi nanti.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Mohon lengkapi semua field.</div>';
    }
}
?>

<div class="container mt-5">
    <!-- Contact Header -->
    <div class="section-header">
        <h2>Hubungi Kami</h2>
        <p class="text-muted">Kami siap membantu Anda</p>
    </div>

    <!-- Contact Information -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="contact-card text-center p-4">
                <i class="fas fa-map-marker-alt contact-icon mb-3"></i>
                <h4>Alamat</h4>
                <p class="text-muted">
                    Jl. Furniture No. 123<br>
                    Jakarta Selatan, 12345<br>
                    Indonesia
                </p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="contact-card text-center p-4">
                <i class="fas fa-phone-alt contact-icon mb-3"></i>
                <h4>Telepon</h4>
                <p class="text-muted">
                    Tel: (021) 1234-5678<br>
                    WA: +62 812-3456-7890
                </p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="contact-card text-center p-4">
                <i class="fas fa-envelope contact-icon mb-3"></i>
                <h4>Email</h4>
                <p class="text-muted">
                    info@wijayafurniture.com<br>
                    sales@wijayafurniture.com
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Form and Map -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="contact-form-card p-4">
                <h3 class="mb-4">Kirim Pesan</h3>
                <?php echo $message; ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="map-card">
                <h3 class="mb-4">Lokasi Kami</h3>
                <div class="ratio ratio-4x3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126915.06709645538!2d106.7891356!3d-6.2297465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%20Selatan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1656938100000!5m2!1sid!2sid" 
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-card {
    background: var(--light-bg);
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.contact-icon {
    font-size: 2.5rem;
    color: var(--secondary-color);
}

.contact-form-card {
    background: var(--light-bg);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.map-card {
    background: var(--light-bg);
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 100%;
}

.form-control {
    border: 1px solid #ddd;
    padding: 0.75rem;
}

.form-control:focus {
    border-color: var(--secondary-color);
    box-shadow: 0 0 0 0.2rem rgba(162, 123, 92, 0.25);
}

.btn-primary {
    padding: 0.75rem 2rem;
}
</style>

<?php include 'includes/footer.php'; ?> 