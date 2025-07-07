@extends('layouts.app')
@section('title', 'EKRAF KUNINGAN')
@section('content')
    <!-- Hero Section -->
    <div class="relative h-64 md:h-96 lg:h-[500px] bg-center bg-cover flex items-center"
        style="background-image: url('{{  secure_asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-center px-6 md:px-12 max-w-6xl mx-auto">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">EKRAF KUNINGAN</h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-6 max-w-3xl mx-auto">
                Platform Ekonomi Kreatif Kabupaten Kuningan
            </p>
            <p class="text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Bergabunglah dengan komunitas kreatif Kuningan untuk mengembangkan potensi dan menciptakan peluang bisnis yang inovatif
            </p>
        </div>
    </div>

   
    <!-- Section Ekonomi Kreatif -->
    <section class="max-w-6xl mx-auto py-14 px-6 grid md:grid-cols-2 gap-8 items-start">
        <div>
            <h2 class="text-orange-500 font-bold text-xl mb-4">Ekonomi Kreatif (Ekraf)</h2>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Ekonomi Kreatif, atau yang sering disingkat sebagai Ekraf, merupakan sektor ekonomi yang bertumpu pada
                kreativitas individu, inovasi, dan pemanfaatan nilai budaya sebagai fondasi utama dalam menciptakan produk
                dan jasa. Dalam ekonomi ini, ide dan gagasan menjadi aset utama yang memiliki nilai jual tinggi, bahkan
                sering kali lebih penting dibandingkan sumber daya alam atau modal fisik.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Ekonomi kreatif mencakup berbagai bidang, seperti seni rupa, desain, musik, film, periklanan, kuliner,
                fashion, arsitektur, hingga pengembangan aplikasi dan permainan digital. Sektor ini berkembang pesat seiring
                kemajuan teknologi dan meningkatnya kebutuhan masyarakat akan produk dan layanan yang unik, personal, serta
                sarat nilai estetika dan budaya.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Salah satu ciri khas dari ekonomi kreatif adalah kemampuannya untuk terus berinovasi. Pelaku ekonomi kreatif
                tidak hanya menciptakan sesuatu yang baru, tetapi juga mengolah kembali unsur-unsur budaya lokal dan
                mengadaptasinya sesuai kebutuhan zaman. Oleh karena itu, ekonomi kreatif juga berperan penting dalam
                pelestarian budaya sekaligus peningkatan daya saing bangsa di era global.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700">
                Pemerintah Indonesia pun memberikan perhatian serius terhadap pengembangan sektor ini, karena dinilai mampu
                menjadi salah satu motor penggerak ekonomi nasional, membuka lapangan pekerjaan, serta meningkatkan
                kesejahteraan masyarakat.
            </p>
        </div>
        <div class="flex justify-center">
            <img src="{{ secure_asset('assets/img/Lobby.png') }}" alt="Lobby"
                class="rounded-lg shadow-md w-[300px] object-cover">
        </div>
    </section>


    <!-- Section Sub Sektor -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    <span class="text-orange-500">Sub Sektor</span> Ekonomi Kreatif
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                    Jelajahi berbagai subsektor ekonomi kreatif yang berkembang di Kabupaten Kuningan
                </p>
                <div class="w-24 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Carousel Container -->
            <div class="relative mb-8">
                <!-- Carousel Wrapper -->
                <div class="overflow-hidden">
                    <div id="subsektorCarousel" class="flex transition-transform duration-500 ease-in-out">
                        @php
                            $allItems = collect([['type' => 'all']])->concat($subsektors->map(fn($sub) => ['type' => 'subsektor', 'data' => $sub]));
                            $itemsPerPage = 6; // 3 cards per row, 2 rows
                            $pages = $allItems->chunk($itemsPerPage);
                        @endphp

                        @foreach($pages as $pageIndex => $pageItems)
                        <!-- Page {{ $pageIndex + 1 }} -->
                        <div class="w-full flex-shrink-0">
                            @php
                                $firstRow = $pageItems->take(3);
                                $secondRow = $pageItems->skip(3)->take(3);
                            @endphp
                            
                            <!-- First row -->
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                @foreach($firstRow as $item)
                                    @if($item['type'] === 'all')
                                        <!-- Card All -->
                                        <a href="{{ route('katalog') }}" class="group transform transition-all duration-300 hover:scale-105">
                                            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-center border border-gray-100 hover:border-orange-200 relative overflow-hidden h-40">
                                                <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full transform translate-x-4 -translate-y-4"></div>
                                                <div class="relative z-10 h-full flex flex-col justify-center">
                                                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 mb-1">Semua Sektor</h3>
                                                    <p class="text-xs text-gray-500">Lihat semua Mitra kreatif</p>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        @php $sub = $item['data']; @endphp
                                        <!-- Card Subsektor -->
                                        <a href="{{ route('katalog.subsektor', $sub->slug) }}" class="group transform transition-all duration-300 hover:scale-105">
                                            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-center border border-gray-100 hover:border-orange-200 relative overflow-hidden h-40">
                                                <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full transform translate-x-4 -translate-y-4"></div>
                                                <div class="relative z-10 h-full flex flex-col justify-center">
                                                    <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg border-4 border-gray-100 overflow-hidden">
                                                        @if($sub->image)
                                                            <img src="{{ secure_asset('storage/' . $sub->image) }}" alt="{{ $sub->title }}" class="w-full h-full object-cover" />
                                                        @else
                                                            @php
                                                                $iconName = 'default';
                                                                $lowerTitle = strtolower($sub->title);
                                                                if (str_contains($lowerTitle, 'aplikasi') || str_contains($lowerTitle, 'game') || str_contains($lowerTitle, 'developer')) {
                                                                    $iconName = 'aplikasi';
                                                                } elseif (str_contains($lowerTitle, 'arsitektur')) {
                                                                    $iconName = 'arsitektur';
                                                                } elseif (str_contains($lowerTitle, 'desain')) {
                                                                    $iconName = 'desain';
                                                                } elseif (str_contains($lowerTitle, 'fotografi')) {
                                                                    $iconName = 'fotografi';
                                                                } elseif (str_contains($lowerTitle, 'fashion') || str_contains($lowerTitle, 'busana')) {
                                                                    $iconName = 'fashion';
                                                                } elseif (str_contains($lowerTitle, 'film') || str_contains($lowerTitle, 'video') || str_contains($lowerTitle, 'animasi')) {
                                                                    $iconName = 'film';
                                                                } elseif (str_contains($lowerTitle, 'kuliner') || str_contains($lowerTitle, 'makanan')) {
                                                                    $iconName = 'kuliner';
                                                                } elseif (str_contains($lowerTitle, 'musik')) {
                                                                    $iconName = 'musik';
                                                                } elseif (str_contains($lowerTitle, 'kriya') || str_contains($lowerTitle, 'kerajinan')) {
                                                                    $iconName = 'kriya';
                                                                } elseif (str_contains($lowerTitle, 'seni') || str_contains($lowerTitle, 'rupa')) {
                                                                    $iconName = 'seni';
                                                                } else {
                                                                    $iconName = 'kreatif';
                                                                }
                                                            @endphp
                                                            <img src="{{ secure_asset('assets/img/icons/subsektor-' . $iconName . '.svg') }}" alt="{{ $sub->title }}" class="w-12 h-12 object-contain" />
                                                        @endif
                                                    </div>
                                                    <h3 class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 mb-1 leading-tight">{{ $sub->title }}</h3>
                                                    @if($sub->description)
                                                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($sub->description), 45) }}</p>
                                                    @else
                                                        <p class="text-xs text-gray-500">Subsektor ekonomi kreatif</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach

                                @if($firstRow->count() < 3)
                                    @for($i = $firstRow->count(); $i < 3; $i++)
                                        <div class="opacity-0"></div>
                                    @endfor
                                @endif
                            </div>
                            
                            <!-- Second row -->
                            @if($secondRow->count() > 0)
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($secondRow as $item)
                                    @if($item['type'] === 'all')
                                        <!-- Card All -->
                                        <a href="{{ route('katalog') }}" class="group transform transition-all duration-300 hover:scale-105">
                                            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-center border border-gray-100 hover:border-orange-200 relative overflow-hidden h-40">
                                                <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full transform translate-x-4 -translate-y-4"></div>
                                                <div class="relative z-10 h-full flex flex-col justify-center">
                                                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 mb-1">Semua Sektor</h3>
                                                    <p class="text-xs text-gray-500">Lihat semua produk kreatif</p>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        @php $sub = $item['data']; @endphp
                                        <!-- Card Subsektor -->
                                        <a href="{{ route('katalog.subsektor', $sub->slug) }}" class="group transform transition-all duration-300 hover:scale-105">
                                            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-center border border-gray-100 hover:border-orange-200 relative overflow-hidden h-40">
                                                <div class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full transform translate-x-4 -translate-y-4"></div>
                                                <div class="relative z-10 h-full flex flex-col justify-center">
                                                    <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg border-4 border-gray-100 overflow-hidden">
                                                        @if($sub->image)
                                                            <img src="{{ secure_asset('storage/' . $sub->image) }}" alt="{{ $sub->title }}" class="w-full h-full object-cover" />
                                                        @else
                                                            @php
                                                                $iconName = 'default';
                                                                $lowerTitle = strtolower($sub->title);
                                                                if (str_contains($lowerTitle, 'aplikasi') || str_contains($lowerTitle, 'game') || str_contains($lowerTitle, 'developer')) {
                                                                    $iconName = 'aplikasi';
                                                                } elseif (str_contains($lowerTitle, 'arsitektur')) {
                                                                    $iconName = 'arsitektur';
                                                                } elseif (str_contains($lowerTitle, 'desain')) {
                                                                    $iconName = 'desain';
                                                                } elseif (str_contains($lowerTitle, 'fotografi')) {
                                                                    $iconName = 'fotografi';
                                                                } elseif (str_contains($lowerTitle, 'fashion') || str_contains($lowerTitle, 'busana')) {
                                                                    $iconName = 'fashion';
                                                                } elseif (str_contains($lowerTitle, 'film') || str_contains($lowerTitle, 'video') || str_contains($lowerTitle, 'animasi')) {
                                                                    $iconName = 'film';
                                                                } elseif (str_contains($lowerTitle, 'kuliner') || str_contains($lowerTitle, 'makanan')) {
                                                                    $iconName = 'kuliner';
                                                                } elseif (str_contains($lowerTitle, 'musik')) {
                                                                    $iconName = 'musik';
                                                                } elseif (str_contains($lowerTitle, 'kriya') || str_contains($lowerTitle, 'kerajinan')) {
                                                                    $iconName = 'kriya';
                                                                } elseif (str_contains($lowerTitle, 'seni') || str_contains($lowerTitle, 'rupa')) {
                                                                    $iconName = 'seni';
                                                                } else {
                                                                    $iconName = 'kreatif';
                                                                }
                                                            @endphp
                                                            <img src="{{ secure_asset('assets/img/icons/subsektor-' . $iconName . '.svg') }}" alt="{{ $sub->title }}" class="w-12 h-12 object-contain" />
                                                        @endif
                                                    </div>
                                                    <h3 class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 mb-1 leading-tight">{{ $sub->title }}</h3>
                                                    @if($sub->description)
                                                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($sub->description), 45) }}</p>
                                                    @else
                                                        <p class="text-xs text-gray-500">Subsektor ekonomi kreatif</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach

                                @if($secondRow->count() < 3)
                                    @for($i = $secondRow->count(); $i < 3; $i++)
                                        <div class="opacity-0"></div>
                                    @endfor
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                @if($pages->count() > 1)
                <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 text-gray-600 hover:text-orange-500 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 text-gray-600 hover:text-orange-500 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                @endif
            </div>

            <!-- Carousel Indicators -->
            @if($pages->count() > 1)
            <div class="flex justify-center space-x-2 mb-8">
                <div id="indicators" class="flex space-x-2"></div>
            </div>
            @endif

            <!-- Info tambahan -->
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-4">
                    Temukan lebih banyak produk kreatif dari berbagai subsektor
                </p>
                <a href="{{ route('katalog') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors duration-300 shadow-md hover:shadow-lg">
                    <span>Jelajahi Semua Katalog</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Carousel JavaScript -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('subsektorCarousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.getElementById('indicators');
            
            if (!carousel) return;

            // Calculate pages from PHP
            @php
                $allItems = collect([['type' => 'all']])->concat($subsektors->map(fn($sub) => ['type' => 'subsektor', 'data' => $sub]));
                $itemsPerPage = 6;
                $totalPages = ceil($allItems->count() / $itemsPerPage);
            @endphp

            const totalPages = {{ $totalPages }};
            let currentPage = 0;

            // Only show navigation if there are multiple pages
            if (totalPages > 1 && prevBtn && nextBtn && indicators) {
                // Create indicators
                for (let i = 0; i < totalPages; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = `w-3 h-3 rounded-full cursor-pointer transition-all duration-300 ${i === 0 ? 'bg-orange-500' : 'bg-gray-300'}`;
                    indicator.addEventListener('click', () => goToPage(i));
                    indicators.appendChild(indicator);
                }

                function updateCarousel() {
                    const translateX = -(currentPage * 100);
                    carousel.style.transform = `translateX(${translateX}%)`;
                    
                    // Update indicators
                    if (indicators) {
                        Array.from(indicators.children).forEach((indicator, index) => {
                            indicator.className = `w-3 h-3 rounded-full cursor-pointer transition-all duration-300 ${index === currentPage ? 'bg-orange-500' : 'bg-gray-300'}`;
                        });
                    }
                }

                function goToPage(page) {
                    currentPage = page;
                    updateCarousel();
                }

                prevBtn.addEventListener('click', () => {
                    currentPage = currentPage > 0 ? currentPage - 1 : totalPages - 1;
                    updateCarousel();
                });

                nextBtn.addEventListener('click', () => {
                    currentPage = currentPage < totalPages - 1 ? currentPage + 1 : 0;
                    updateCarousel();
                });

                // Auto-play carousel every 5 seconds
                setInterval(() => {
                    if (totalPages > 1) {
                        currentPage = currentPage < totalPages - 1 ? currentPage + 1 : 0;
                        updateCarousel();
                    }
                }, 5000);
            } else {
                // Hide navigation elements if not needed
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                if (indicators) indicators.style.display = 'none';
            }
        });
        </script>
    </section>

    <!-- Section Katalog Produk -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    <span class="text-orange-500">Katalog</span> Mitra Ekonomi Kreatif
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                    Temukan berbagai produk kreatif berkualitas dari pelaku UMKM Kabupaten Kuningan
                </p>
                <div class="w-24 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
                @foreach ($katalogs as $kat)
                    <a href="{{ route('katalog.show', $kat->slug) }}" class="block group">
                        <div class="catalog-card bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:scale-105">
                            <!-- Image Container -->
                            <div class="catalog-card-image relative h-48 overflow-hidden">
                                <img src="{{ $kat->image_url }}" 
                                     alt="{{ $kat->title }}"
                                     class="w-full h-full object-cover transition-all duration-300 group-hover:scale-110"
                                     onload="this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                     onerror="this.onerror=null; this.src='{{secure_asset('assets/img/placeholder-catalog.jpg') }}'; this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                     style="opacity:0;">
                                <!-- Loading placeholder -->
                                <div class="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                            </div>
                            
                            <!-- Content Container -->
                            <div class="catalog-card-content p-6">
                                <!-- Title -->
                                <h3 class="catalog-card-title text-lg font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 mb-3 line-clamp-2 leading-tight">
                                    {{ $kat->title }}
                                </h3>
                                
                                <!-- Description -->
                                <p class="catalog-card-description text-sm text-gray-600 line-clamp-3 leading-relaxed mb-4">
                                    {{ Str::limit(strip_tags($kat->content), 120) ?: 'Koleksi produk kreatif dari pelaku UMKM lokal yang menghadirkan inovasi dan kualitas terbaik' }}
                                </p>
                                
                                <!-- Footer -->
                                <div class="catalog-card-footer flex items-center justify-between">
                                    <span class="inline-flex items-center bg-orange-50 text-orange-600 text-xs px-3 py-1.5 rounded-full font-medium border border-orange-200">
                                        @if($kat->subSektor && $kat->subSektor->image)
                                            <img src="{{ secure_asset('storage/' . $kat->subSektor->image) }}" alt="{{ $kat->subSektor->title }}" class="w-4 h-4 mr-1.5 object-contain" />
                                        @else
                                            @php
                                                $iconName = 'default';
                                                if($kat->subSektor) {
                                                    $lowerTitle = strtolower($kat->subSektor->title);
                                                    if (str_contains($lowerTitle, 'aplikasi') || str_contains($lowerTitle, 'game') || str_contains($lowerTitle, 'developer')) {
                                                        $iconName = 'aplikasi';
                                                    } elseif (str_contains($lowerTitle, 'arsitektur')) {
                                                        $iconName = 'arsitektur';
                                                    } elseif (str_contains($lowerTitle, 'desain')) {
                                                        $iconName = 'desain';
                                                    } elseif (str_contains($lowerTitle, 'fotografi')) {
                                                        $iconName = 'fotografi';
                                                    } elseif (str_contains($lowerTitle, 'fashion') || str_contains($lowerTitle, 'busana')) {
                                                        $iconName = 'fashion';
                                                    } elseif (str_contains($lowerTitle, 'film') || str_contains($lowerTitle, 'video') || str_contains($lowerTitle, 'animasi')) {
                                                        $iconName = 'film';
                                                    } elseif (str_contains($lowerTitle, 'kuliner') || str_contains($lowerTitle, 'makanan')) {
                                                        $iconName = 'kuliner';
                                                    } elseif (str_contains($lowerTitle, 'musik')) {
                                                        $iconName = 'musik';
                                                    } elseif (str_contains($lowerTitle, 'kriya') || str_contains($lowerTitle, 'kerajinan')) {
                                                        $iconName = 'kriya';
                                                    } elseif (str_contains($lowerTitle, 'seni') || str_contains($lowerTitle, 'rupa')) {
                                                        $iconName = 'seni';
                                                    } else {
                                                        $iconName = 'kreatif';
                                                    }
                                                }
                                            @endphp
                                            <img src="{{ secure_asset('assets/img/icons/subsektor-' . $iconName . '.svg') }}" alt="icon" class="w-4 h-4 mr-1.5 object-contain" />
                                        @endif
                                        {{ $kat->subSektor->title ?? 'Sub Sektor' }}
                                    </span>
                                    @if($kat->products->count() > 0)
                                        <span class="text-xs text-gray-500 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            {{ $kat->products->count() }} produk
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center">
                <button onclick="window.location.href='{{ route('katalog') }}'"
                    class="inline-flex items-center px-8 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                    <span>Katalog Lainnya</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>
            </button>
        </div>
    </section>


    <!-- Section Manfaat -->
    <section class="max-w-6xl mx-auto py-14 px-6">
        <h2 class="text-center text-orange-500 font-semibold text-xl mb-12">Manfaat Menjadi Anggota ekraf Kuningan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 text-gray-700">
            <div class="space-y-8">
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">1.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Sinergi dengan Pelaku Kreatif</h3>
                        <p class="text-sm leading-relaxed">Menjadi anggota forum ini membuka peluang untuk bekerja sama
                            dengan berbagai insan kreatif di Bandung Barat, sehingga memperkaya wawasan dan pengalaman Anda.
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">3.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Dukungan untuk Pertumbuhan Usaha</h3>
                        <p class="text-sm leading-relaxed">Forum ini menjadi sarana untuk memperkenalkan bisnis Anda kepada
                            audiens yang tepat, sekaligus memperoleh bimbingan dalam mengembangkan usaha lebih lanjut.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">5.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Komunitas yang Mendukung</h3>
                        <p class="text-sm leading-relaxed">Anda akan menjadi bagian dari komunitas yang saling membantu,
                            memberikan semangat saat menghadapi tantangan, dan ikut merayakan setiap pencapaian Anda.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">7.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Meningkatkan Citra dan Eksistensi Usaha</h3>
                        <p class="text-sm leading-relaxed">Dengan aktif terlibat dalam kegiatan forum dan berkolaborasi
                            dengan sesama anggota, Anda bisa memperkuat brand awareness dan eksistensi bisnis Anda.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-8">
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">2.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Perluasan Relasi Profesional</h3>
                        <p class="text-sm leading-relaxed">Keanggotaan membantu Anda memperluas koneksi, menjalin hubungan
                            baru, dan membuka akses ke berbagai peluang usaha dan sumber daya.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">4.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Kesempatan Belajar dan Mengasah Skill</h3>
                        <p class="text-sm leading-relaxed">Nikmati berbagai program pelatihan, workshop, dan kegiatan
                            edukatif yang disediakan forum untuk meningkatkan keahlian di sektor ekonomi kreatif.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">6.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Informasi Terkini</h3>
                        <p class="text-sm leading-relaxed">Dapatkan update terbaru mengenai tren industri, peluang usaha,
                            serta event kreatif di kawasan Bandung Barat.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">8.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Akses Fasilitas Pendukung Usaha</h3>
                        <p class="text-sm leading-relaxed">Sebagai anggota, Anda bisa mengakses fasilitas bersama seperti
                            ruang kerja, alat-alat kreatif, dan sumber daya lainnya yang mendukung efisiensi usaha Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
