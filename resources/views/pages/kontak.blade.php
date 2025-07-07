@extends('layouts.app')
@section('title', 'KONTAK - EKRAF KUNINGAN')

@section('content')
    <!-- Banner -->
    <div class="relative h-44 md:h-15 bg-center bg-cover flex items-center"
        style="background-image: url('{{ asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > Kontak
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">KONTAK</h1>
        </div>
    </div>


    <!-- Kontak -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <h2 class="text-2xl font-bold text-gray-800">Hubungi Kami !</h2>
                <p class="text-gray-600">Ayo Kolaborasi Dengan Ekraf, Dukung UMKM Dan Wujudkan Ide Kreatif Bersama!</p>
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Anda*"
                            class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none">
                        <input type="text" placeholder="Nomor Telepon*"
                            class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none">
                        <input type="email" placeholder="Alamat Email*"
                            class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none">
                        <input type="text" placeholder="Judul*"
                            class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none">
                    </div>
                    <textarea placeholder="Tuliskan Pesan*" rows="5"
                        class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none"></textarea>
                    <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">KIRIM</button>
                </form>
            </div>

            <div>
                <h3 class="text-xl font-bold text-orange-500 mb-4">Get in Touch</h3>
                <div class="space-y-4 text-gray-600 text-sm">
                    <div>
                        <h4 class="font-semibold">HUBUNGI KAMI :</h4>
                        <p>(0232) 8730550</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">INSTAGRAM :</h4>
                        <p>@ekrafkuningan.id</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">JAM LAYANAN :</h4>
                        <p>Senin - Jumat 08.00 - 16.00 WIB</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">ALAMAT :</h4>
                        <p>Jl. Siliwangi No. 88, Kuningan, Jawa Barat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps -->
    <section class="w-full">
        <iframe src="https://www.google.com/maps?q=2F9H%2BC7+Kuningan,+Kabupaten+Kuningan,+Jawa+Barat&output=embed"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>

    </section>
@endsection
