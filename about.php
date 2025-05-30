<?php
require_once 'config/database.php';
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="section-header text-center mb-5">
        <h2>Tentang Kami</h2>
        <p class="text-muted">Mengenal lebih dekat dengan Wijaya Furniture</p>
    </div>

    <!-- Cerita Kami -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1887&q=80" 
                     class="img-fluid rounded shadow" 
                     alt="Wijaya Furniture Products">
            </div>
        </div>
        <div class="col-md-6">
            <div class="about-content ps-md-4 mt-4 mt-md-0">
                <h3 class="mb-4">Cerita Kami</h3>
                <p>Wijaya Furniture didirikan pada tahun 2010 dengan visi untuk menyediakan furniture berkualitas tinggi dengan harga yang terjangkau. Berawal dari sebuah workshop kecil di Jepara, kota yang terkenal dengan kerajinan furniture-nya, kami terus berkembang berkat kepercayaan dan dukungan dari pelanggan setia kami.</p>
                <p>Setiap produk kami dibuat dengan penuh ketelitian oleh para pengrajin berpengalaman, menggunakan bahan-bahan pilihan untuk memastikan kualitas terbaik. Kami percaya bahwa furniture yang baik tidak hanya tentang estetika, tetapi juga tentang kenyamanan dan ketahanan. Dengan warisan budaya ukir Jepara yang kaya, kami menggabungkan keahlian tradisional dengan desain modern untuk menciptakan furniture berkualitas tinggi.</p>
                <div class="row g-4 mt-4">
                    <div class="col-6">
                        <div class="achievement-item text-center p-3 rounded">
                            <i class="fas fa-users fa-2x mb-3 text-primary"></i>
                            <h4 class="counter">1000+</h4>
                            <p class="mb-0">Pelanggan Puas</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="achievement-item text-center p-3 rounded">
                            <i class="fas fa-trophy fa-2x mb-3 text-primary"></i>
                            <h4>13+</h4>
                            <p class="mb-0">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workshop Kami -->
    <div class="row align-items-center mb-5 flex-md-row-reverse">
        <div class="col-md-6">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1592078615290-033ee584e267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1964&q=80" 
                     class="img-fluid rounded shadow" 
                     alt="Wijaya Furniture Chairs">
            </div>
        </div>
        <div class="col-md-6">
            <div class="about-content pe-md-4 mt-4 mt-md-0">
                <h3 class="mb-4">Workshop Kami</h3>
                <p>Di workshop kami, setiap detail diperhatikan dengan seksama. Mulai dari pemilihan bahan baku hingga proses finishing, semua dilakukan dengan standar kualitas tinggi. Para pengrajin kami memiliki pengalaman bertahun-tahun dalam industri furniture.</p>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Bahan baku berkualitas tinggi
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Pengrajin berpengalaman
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Proses produksi modern
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Quality control ketat
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Values -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="value-card text-center p-4">
                <i class="fas fa-medal value-icon mb-3"></i>
                <h4>Kualitas Terbaik</h4>
                <p class="text-muted">Menggunakan material berkualitas tinggi dan pengerjaan yang teliti</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="value-card text-center p-4">
                <i class="fas fa-hand-holding-heart value-icon mb-3"></i>
                <h4>Pelayanan Prima</h4>
                <p class="text-muted">Memberikan pelayanan terbaik dan after-sales service yang memuaskan</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="value-card text-center p-4">
                <i class="fas fa-lightbulb value-icon mb-3"></i>
                <h4>Inovasi Desain</h4>
                <p class="text-muted">Selalu mengikuti tren desain terkini dan kebutuhan pelanggan</p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="section-header">
        <h3>Tim Kami</h3>
        <p class="text-muted">Bertemu dengan para profesional di balik Wijaya Furniture</p>
    </div>

    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80" alt="CEO" class="team-img mb-3">
                <h5>Budi Wijaya</h5>
                <p class="text-muted">CEO & Founder</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?auto=format&fit=crop&w=400&q=80" alt="Designer" class="team-img mb-3">
                <h5>Siti Rahayu</h5>
                <p class="text-muted">Lead Designer</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1516257984-b1b4d707412e?auto=format&fit=crop&w=400&q=80" alt="Production" class="team-img mb-3">
                <h5>Ahmad Santoso</h5>
                <p class="text-muted">Production Manager</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=400&q=80" alt="Marketing" class="team-img mb-3">
                <h5>Linda Kusuma</h5>
                <p class="text-muted">Marketing Director</p>
            </div>
        </div>
    </div>
</div>

<style>
.about-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.achievement-item {
    background: var(--light-bg);
    transition: all 0.3s ease;
}

.achievement-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.achievement-item i {
    color: var(--secondary-color);
}

.achievement-item h4 {
    color: var(--primary-color);
    font-weight: 600;
    margin: 10px 0;
}

@media (max-width: 768px) {
    .about-image img {
        height: 300px;
    }
}

.value-card {
    background: var(--light-bg);
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.value-icon {
    font-size: 2.5rem;
    color: var(--secondary-color);
}

.team-img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid var(--light-bg);
    transition: transform 0.3s ease;
}

.team-card:hover .team-img {
    transform: scale(1.1);
}

.team-card h5 {
    color: var(--primary-color);
    margin-bottom: 5px;
}
</style>

<?php include 'includes/footer.php'; ?> 