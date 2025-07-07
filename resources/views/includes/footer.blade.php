<!-- Section CTA dengan background image + overlay -->
<section class="relative bg-center bg-cover"
    style="background-image: url('{{ asset('assets/img/BackgroundFooter.png') }}')">
    <div class="max-w-4xl mx-auto text-center py-20 text-white px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Bergabunglah dengan Galeri EKRAF Kuningan</h2>
        <p class="mb-6 text-sm md:text-base">Daftarkan usaha kreatif Anda dan dapatkan berbagai manfaat untuk
            mengembangkan bisnis anda ke tingkat yang lebih tinggi</p>
        <div class="flex justify-center gap-4 flex-wrap mb-8">
            <a href="#"
                class="bg-white text-[#1E293B] font-semibold px-6 py-3 rounded hover:bg-gray-200 flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <a href="/"
                class="border border-white px-6 py-3 rounded hover:bg-white hover:text-[#1E293B] flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Pelajari Manfaat
            </a>
        </div>
        <div>
            <h3 class="text-sm md:text-base font-semibold mb-2">Dapatkan Informasi Terbaru</h3>
            <div class="flex justify-center flex-wrap gap-2">
                <input type="email" placeholder="Alamat email Anda"
                    class="px-4 py-2 rounded bg-white text-gray-800 w-64 focus:outline-none">
                <button class="px-4 py-2 bg-white text-[#1E293B] rounded hover:bg-gray-200">Berlangganan</button>
            </div>
        </div>
    </div>
</section>


<!-- Footer navy polos -->
<footer class="bg-[#1E293B] text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-6 py-12">
        <div class="space-y-4">
            <img src="{{ asset('assets/img/LogoEkrafPutih.png') }}" alt="Logo" class="h-12">
            <p class="text-sm text-gray-400">
                Mendorong pertumbuhan ekonomi kreatif Kuningan melalui inovasi dan pelestarian budaya lokal.
            </p>
            <div class="flex space-x-4 mt-4 text-xl">
                <a href="#" class="hover:text-orange-400"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kuningankreatifgaleri/" class="hover:text-orange-400"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-orange-400"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-orange-400"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div>
            <h3 class="font-bold mb-4">Tautan Cepat</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="/" class="hover:text-white">Beranda</a></li>
                <li><a href="/katalog" class="hover:text-white">Katalog Produk</a></li>
                <li><a href="/berita" class="hover:text-white">Artikel & Berita</a></li>
                <li><a href="/tentang" class="hover:text-white">Tentang Kami</a></li>
                <li><a href="/kontak" class="hover:text-white">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-4">Layanan</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="#" class="hover:text-white">Pendaftaran EKRAF</a></li>
                <li><a href="#" class="hover:text-white">Pelatihan & Workshop</a></li>
                <li><a href="#" class="hover:text-white">Konsultasi Bisnis</a></li>
                <li><a href="#" class="hover:text-white">Akses Pendanaan</a></li>
                <li><a href="#" class="hover:text-white">Promosi Produk</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-4">Kontak Kami</h3>
            <p class="text-gray-400 text-sm">Jl. Siliwangi No. 88, Kuningan, Jawa Barat 45511</p>
            <p class="text-gray-400 text-sm mt-2">(0232) 8730550</p>
            <p class="text-gray-400 text-sm mt-2">info@ekrafkuningan.id</p>
            <p class="text-gray-400 text-sm mt-2">Senin - Jumat 08.00 - 16.00 WIB</p>
        </div>
    </div>
    <div class="border-t border-gray-700 text-center py-4 text-gray-500 text-sm">
        © 2025 KUNINGAN KREATIF GALERI (Fachrul, Nurlatif) . All rights reserved.
    </div>
</footer>
