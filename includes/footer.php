<footer class="footer mt-5">
    <div class="footer-top py-4">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4">
                    <div class="footer-info">
                        <h3 class="footer-logo mb-3">
                            <i class="fas fa-couch me-2"></i>Wijaya Furniture
                        </h3>
                        <p class="mb-3">
                            Menyediakan furniture berkualitas dengan sentuhan ukiran khas Jepara.
                        </p>
                        <div class="social-links">
                            <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="footer-contact">
                        <h4 class="mb-3">Hubungi Kami</h4>
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Jl. Sukun Raya No. 21, Jepara
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:+6282123456789">0821-2345-6789</a>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:info@wijayafurniture.com">info@wijayafurniture.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3">
        <div class="container">
            <div class="text-center">
                &copy; <?php echo date('Y'); ?> Wijaya Furniture. All Rights Reserved
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: var(--primary-color);
    color: #fff;
}

.footer-logo {
    font-size: 1.5rem;
    font-weight: 600;
    color: #fff;
}

.footer h4 {
    font-size: 1.2rem;
    font-weight: 600;
}

.social-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.social-links a:hover {
    color: var(--secondary-color);
}

.footer-contact a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-contact a:hover {
    color: var(--secondary-color);
}

.footer-bottom {
    background: rgba(0,0,0,0.1);
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-info, .footer-contact {
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
        margin-bottom: 1rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html> 