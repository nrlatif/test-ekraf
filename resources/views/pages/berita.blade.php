@extends('layouts.app')
@section('title', 'ARTIKEL - EKRAF KUNINGAN')
@section('content')
    <div class="relative h-44 md:h-15 bg-center bg-cover flex items-center"
        style="background-image: url('{{ secure_asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > Artikel
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">ARTIKEL</h1>
        </div>
    </div>

    @if($banners->count() > 0)
    <!-- Banner Slider Section -->
    <section class="max-w-6xl mx-auto px-4 md:px-6 lg:px-8 py-8">
        <div class="banner-slider swiper-container relative">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <div class="relative h-64 md:h-80 lg:h-96 rounded-xl overflow-hidden">
                        <!-- Background Image with better positioning -->
                        <div class="absolute inset-0 bg-center bg-cover bg-no-repeat"
                             style="background-image: url('{{ $banner->image_url ?? ($banner->artikel ? $banner->artikel->thumbnail_url : secure_asset('assets/img/BGKontak.png')) }}');">
                        </div>
                        
                        <!-- Enhanced Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10"></div>
                        
                        <!-- Content Container -->
                        <div class="relative z-10 h-full flex flex-col justify-end p-6 md:p-8 slide-content">
                            <!-- Category Badge -->
                            @if($banner->artikel && $banner->artikel->artikelKategori)
                            <div class="mb-3">
                                <span class="inline-block bg-orange-500/90 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1.5 rounded-full border border-orange-400/30">
                                    {{ $banner->artikel->artikelKategori->title }}
                                </span>
                            </div>
                            @endif
                            
                            <!-- Title -->
                            <h2 class="text-xl md:text-3xl lg:text-4xl font-bold text-white mb-3 leading-tight">
                                {{ $banner->title ?? $banner->artikel->title ?? 'Untitled' }}
                            </h2>
                            
                            <!-- Description -->
                            @if($banner->description)
                            <p class="text-white/95 text-sm md:text-base mb-4 line-clamp-2 leading-relaxed">
                                {{ $banner->description }}
                            </p>
                            @endif
                            
                            <!-- Author Info -->
                            @if($banner->artikel && $banner->artikel->author)
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white/30">
                                    <img src="{{ $banner->artikel->author->avatar_url }}" 
                                         alt="{{ $banner->artikel->author->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $banner->artikel->author->name }}</p>
                                    <p class="text-white/80 text-xs">{{ $banner->artikel->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Action Button -->
                            <div class="flex items-center">
                                @if($banner->artikel)
                                <a href="{{ route('artikels.show', $banner->artikel->slug) }}" 
                                   class="btn-read-article inline-flex items-center justify-center px-6 py-3 bg-orange-500/90 hover:bg-orange-600 text-white font-semibold rounded-lg transition-all duration-300 group">
                                    <span>Baca Artikel</span>
                                    <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                                </a>
                                @elseif($banner->link_url)
                                <a href="{{ $banner->link_url }}" 
                                   target="_blank"
                                   class="btn-read-article inline-flex items-center justify-center px-6 py-3 bg-orange-500/90 hover:bg-orange-600 text-white font-semibold rounded-lg transition-all duration-300 group">
                                    <span>Selengkapnya</span>
                                    <i class="fas fa-external-link-alt ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Navigation buttons -->
            @if($banners->count() > 1)
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
            @endif
        </div>
    </section>
    @endif
    <!-- Berita Unggulan -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-12">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-8">
            <div class="font-bold text-2xl text-center md:text-left">
                <p>Berita Unggulan</p>
                <p>Untuk Kamu</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($featureds as $featured)
                <a href="{{ route('artikels.show', $featured->slug) }}">
                    <div class="bg-white border border-slate-200 p-3 rounded-xl shadow-sm hover:shadow-md hover:border-primary transition duration-300 ease-in-out"
                        style="height: 100%">

                        <div class="mb-2">
                            <img src="{{ $featured->thumbnail_url }}" alt="Thumbnail"
                                class="w-full h-40 object-cover rounded-md">
                        </div>

                        <span
                            class="bg-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-2 inline-block">
                            {{ $featured->artikelkategori->title ?? 'Kategori' }}
                        </span>

                        <p class="font-bold text-base mb-1 text-gray-900 line-clamp-2">
                            {{ $featured->title }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($featured->created_at)->format('d F Y') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    <!-- Berita Terbaru -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
            <div class="font-bold text-2xl text-center md:text-left">
                <p>Berita Terbaru</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @if (isset($artikels[0]))
                <!-- Berita Utama -->
                <div class="col-span-12 lg:col-span-7">
                    <a href="{{ route('artikels.show', $artikels[0]->slug) }}"
                        class="block bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                        <div class="relative">
                            <img src="{{ $artikels[0]->thumbnail_url }}" alt="berita utama"
                                class="w-full h-64 object-cover rounded-t-xl">
                            <span
                                class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                {{ $artikels[0]->artikelkategori->title ?? 'Kategori' }}
                            </span>
                        </div>
                        <div class="p-4">
                            <p class="font-bold text-xl mb-2 text-gray-900 leading-snug line-clamp-2">
                                {{ $artikels[0]->title }}
                            </p>
                            <p class="text-slate-600 text-sm mb-2 leading-relaxed line-clamp-2">
                                {!! Str::limit(strip_tags($artikels[0]->body), 90) !!}
                            </p>
                            <p class="text-sm text-gray-400">
                                {{ \Carbon\Carbon::parse($artikels[0]->created_at)->format('d F Y') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif

            <!-- List Berita Lainnya -->
            <div class="col-span-12 lg:col-span-5 flex flex-col gap-4">
                @foreach ($artikels->skip(1)->take(3) as $artikel)
                    <a href="{{ route('artikels.show', $artikel->slug) }}"
                        class="flex gap-3 border border-slate-200 p-3 rounded-xl shadow-sm hover:border-primary hover:shadow-md transition duration-300 bg-white">
                        <div class="relative w-1/3">
                            <img src="{{ $artikel->thumbnail_url }}" alt="berita"
                                class="rounded-xl h-24 w-full object-cover">
                            <span
                                class="absolute top-1 left-1 bg-orange-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow-sm">
                                {{ $artikel->artikelkategori->title ?? 'Kategori' }}
                            </span>
                        </div>
                        <div class="w-2/3">
                            <p class="font-semibold text-sm text-gray-900 leading-tight mb-1 line-clamp-2">
                                {{ $artikel->title }}
                            </p>
                            <p class="text-slate-500 text-xs leading-snug mb-1 line-clamp-2">
                                {!! Str::limit(strip_tags($artikel->body), 70) !!}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($artikel->created_at)->format('d F Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>



    <!-- Author -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-12">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-8">
            <div class="font-bold text-2xl text-center md:text-left leading-tight">
                <p>Kenali Author</p>
                <p>Terbaik Dari Kami</p>
            </div>
            <a href="register.html"
                class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 shadow hover:shadow-md transition">
                Gabung Menjadi Author
            </a>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($authors as $author)
                <a href="{{ route('author.show', $author->username) }}"
                    class="border border-slate-200 bg-white p-6 rounded-2xl flex flex-col items-center text-center shadow-sm hover:shadow-md hover:border-primary transition duration-300 ease-in-out">
                    <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}"
                        class="rounded-full w-24 h-24 object-cover mb-4 border-2 border-primary shadow">
                    <p class="font-semibold text-lg text-gray-800">{{ $author->name }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $author->artikel->count() }} Berita</p>
                </a>
            @endforeach
        </div>
    </div>


    <!-- Pilihan Author -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10 mb-10">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
            <div class="font-bold text-2xl text-center md:text-left">
                <p>Pilihan Author</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($artikels as $artikel)
                <a href="{{ route('artikels.show', $artikel->slug) }}">
                    <div
                        class="bg-white border border-slate-200 p-3 rounded-xl shadow-sm hover:shadow-md hover:border-primary transition duration-300 ease-in-out h-full overflow-hidden">

                        <div class="mb-2">
                            <img src="{{ $artikel->thumbnail_url }}" alt="{{ $artikel->title }}"
                                class="w-full h-40 object-cover rounded-md">
                        </div>

                        <span
                            class="bg-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-2 inline-block">
                            {{ $artikel->artikelkategori->title ?? 'Kategori' }}
                        </span>

                        <p class="font-bold text-base mb-1 text-gray-900 line-clamp-2">
                            {{ $artikel->title }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($artikel->created_at)->format('d F Y') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection

@push('styles')
<style>
    .banner-slider {
        width: 100%;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        margin: 0;
        padding: 0;
    }
    
    .banner-slider .swiper-slide {
        position: relative;
        overflow: hidden;
    }
    
    .banner-slider .swiper-button-next,
    .banner-slider .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-top: -25px;
        transition: all 0.3s ease;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10;
    }
    
    .banner-slider .swiper-button-next:hover,
    .banner-slider .swiper-button-prev:hover {
        background: rgba(249, 115, 22, 0.9);
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
    }
    
    .banner-slider .swiper-button-next:after,
    .banner-slider .swiper-button-prev:after {
        font-size: 18px;
        font-weight: 700;
    }
    
    .banner-slider .swiper-pagination {
        bottom: 24px;
        z-index: 10;
    }
    
    .banner-slider .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: rgba(255, 255, 255, 0.6);
        opacity: 1;
        transition: all 0.3s ease;
        margin: 0 6px;
    }
    
    .banner-slider .swiper-pagination-bullet-active {
        background: #f97316;
        transform: scale(1.3);
        box-shadow: 0 4px 8px rgba(249, 115, 22, 0.4);
    }
    
    /* Content styling improvements */
    .banner-slider .slide-content {
        animation: slideUp 0.8s ease-out forwards;
    }
    
    @keyframes slideUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Text shadow for better readability */
    .banner-slider h2 {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .banner-slider p {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }
    
    /* Button styling */
    .banner-slider .btn-read-article {
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        transition: all 0.3s ease;
    }
    
    .banner-slider .btn-read-article:hover {
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        transform: translateY(-2px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .banner-slider .swiper-button-next,
        .banner-slider .swiper-button-prev {
            width: 40px;
            height: 40px;
            margin-top: -20px;
        }
        
        .banner-slider .swiper-button-next:after,
        .banner-slider .swiper-button-prev:after {
            font-size: 16px;
        }
        
        .banner-slider .swiper-pagination {
            bottom: 16px;
        }
        
        .banner-slider .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            margin: 0 4px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Banner Slider
    const bannerSlider = new Swiper('.banner-slider', {
        loop: true,
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'slide',
        speed: 1000,
        spaceBetween: 0,
        grabCursor: true,
        centeredSlides: true,
        // Enhanced transitions
        on: {
            init: function() {
                // Add pause on hover functionality
                this.el.addEventListener('mouseenter', () => {
                    this.autoplay.stop();
                });
                this.el.addEventListener('mouseleave', () => {
                    this.autoplay.start();
                });
            },
            slideChange: function() {
                // Add animation to slide content
                const activeSlide = this.slides[this.activeIndex];
                const slideContent = activeSlide.querySelector('.slide-content');
                if (slideContent) {
                    slideContent.style.animation = 'none';
                    // Trigger reflow
                    slideContent.offsetHeight;
                    slideContent.style.animation = 'slideUp 0.8s ease-out forwards';
                }
            },
            transitionStart: function() {
                // Hide content during transition
                this.slides.forEach(slide => {
                    const content = slide.querySelector('.slide-content');
                    if (content) {
                        content.style.opacity = '0';
                        content.style.transform = 'translateY(30px)';
                    }
                });
            },
            transitionEnd: function() {
                // Show content after transition
                const activeSlide = this.slides[this.activeIndex];
                const activeContent = activeSlide.querySelector('.slide-content');
                if (activeContent) {
                    activeContent.style.opacity = '1';
                    activeContent.style.transform = 'translateY(0)';
                    activeContent.style.transition = 'all 0.6s ease-out 0.2s';
                }
            }
        },
        // Keyboard navigation
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        // Touch/swipe settings
        touchRatio: 1,
        touchAngle: 45,
        simulateTouch: true,
        allowTouchMove: true,
        threshold: 10,
        shortSwipes: false,
        longSwipes: true,
        longSwipesMs: 300,
        longSwipesRatio: 0.5,
    });
    
    // Add loading state for images
    const slides = document.querySelectorAll('.banner-slider .swiper-slide');
    slides.forEach(slide => {
        const bgElement = slide.querySelector('[style*="background-image"]');
        if (bgElement) {
            // Create a temporary image to check if it loads
            const bgUrl = bgElement.style.backgroundImage.match(/url\(['"]?(.*?)['"]?\)/);
            if (bgUrl && bgUrl[1]) {
                const img = new Image();
                img.onload = function() {
                    bgElement.style.opacity = '1';
                };
                img.onerror = function() {
                    // Fallback to default image
                    bgElement.style.backgroundImage = `url('{{ secure_asset('assets/img/BGKontak.png') }}')`;
                    bgElement.style.opacity = '1';
                };
                bgElement.style.opacity = '0';
                bgElement.style.transition = 'opacity 0.5s ease';
                img.src = bgUrl[1];
            }
        }
    });
});
</script>
@endpush
