<div class="footer-inner container">
    <div class="row text-center text-md-start">
        <div class="col-md-4 mb-4">
            <h5 class="fw-bold text-uppercase">Staaays Sport</h5>
            <p>Staaay Sport adalah platform online Reservasi lapangan futsal, digunakan untuk orang yang ingin membooking lapangan via online.</p>
        </div>

        <div class="col-md-4 mb-4">
            <h5 class="fw-bold text-uppercase">Contact Us</h5>
            <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. KH. RM. Toha No.362 Banjar Waru</p>
            <p><i class="bi bi-envelope-fill me-2"></i>support@staaays.com</p>
            <p><i class="bi bi-telephone-fill me-2"></i>+62 813 8421 6145</p>
        </div>

        <div class="col-md-4 mb-4">
            <h5 class="fw-bold text-uppercase">Newsletter</h5>
            <p>Dapatkan update terbaru dan promo eksklusif langsung ke email Anda.</p>
            <form action="#" method="post" class="newsletter-form"> {{-- Hapus 'd-flex gap-2' --}}
                <input type="email" name="email" placeholder="Masukkan email Anda" required /> {{-- Hapus 'form-control' --}}
                <button type="submit">Subscribe</button> {{-- Hapus 'btn btn-primary' --}}
            </form>
        </div>
    </div>

    <div class="social-icons"> {{-- **Penting: Ubah class ini** --}}
        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a> {{-- Hapus 'text-light me-3 fs-4' --}}
        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
    </div>

    <hr class="border-primary">

    <div class="copyright-text"> {{-- **Penting: Ubah class ini** --}}
        &copy; <?= date('Y') ?> <strong>Staaay.Sport</strong>. Hak cipta dilindungi. | Dibuat dengan ❤️ di Indonesia
    </div>
</div>