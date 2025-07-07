@extends('layouts.app')
@section('title', $author ? $author->name : 'Author')
@section('content')
@if($author)
    <!-- Hero Section with Author Info -->
    <div class="relative bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 py-16">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 text-white">
                <!-- Logo/Icon Section -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 lg:w-40 lg:h-40 bg-white rounded-full p-4 shadow-xl">
                        <div class="w-full h-full bg-orange-500 rounded-full flex items-center justify-center relative overflow-hidden">
                            <img src="{{ $author->avatar_url }}" 
                                 alt="{{ $author->name }}" 
                                 class="w-full h-full object-cover rounded-full"
                                 onload="this.style.opacity='1';"
                                 onerror="this.onerror=null; this.style.opacity='1'; this.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-white text-2xl font-bold\'>{{ strtoupper(substr($author->name, 0, 1)) }}</div>';"
                                 style="opacity:0; transition: opacity 0.3s;">
                            <!-- Decorative elements around the circle -->
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full"></div>
                            <div class="absolute -bottom-1 -left-1 w-4 h-4 bg-green-400 rounded-full"></div>
                            <div class="absolute top-1/2 -right-3 w-3 h-3 bg-blue-400 rounded-full"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Author Info -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ $author->name }}</h1>
                    
                    @if($author->bio)
                        <p class="text-xl lg:text-2xl text-white/90 mb-6 leading-relaxed max-w-4xl">
                            {{ $author->bio }}
                        </p>
                    @else
                        <p class="text-xl lg:text-2xl text-white/90 mb-6 leading-relaxed max-w-4xl">
                            Galeri Ekraf {{ $author->name }} merupakan salah satu cabang tempat Galeri Ekraf 
                            yang berlokasi di Kota Kuningan, Jawa Barat. Galeri Ekraf {{ $author->name }} 
                            dirancang sebagai media untuk memperkenalkan kelembagaan Pariwisata, 
                            memberikan informasi dan edukasi kepada Masyarakat mengenai 
                            pengembangan Pariwisata dan Ekonomi Kreatif, serta menjadi titik masuk 
                            untuk peluang investasi di Kabupaten Kuningan.
                        </p>
                    @endif
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-8 mt-8">
                        <div class="text-center">
                            <div class="text-4xl lg:text-5xl font-bold mb-1">{{ $author->artikel->count() }}</div>
                            <div class="text-lg text-white/80">Artikel</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-6">
            @if($author->artikel->count() > 0)
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Artikel oleh {{ $author->name }}</h2>
                    <p class="text-gray-600 text-lg">{{ $author->artikel->count() }} artikel telah ditulis</p>
                    <div class="w-24 h-1 bg-orange-500 mx-auto mt-4 rounded-full"></div>
                </div>

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($author->artikel as $artikel)
                        <a href="{{ route('artikels.show', $artikel->slug) }}" class="block group">
                            <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-2 overflow-hidden h-full flex flex-col">
                                <!-- Article Image -->
                                <div class="relative h-56 bg-gray-100 overflow-hidden">
                                    <img src="{{ $artikel->thumbnail_url }}" 
                                         alt="{{ $artikel->title }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                         onload="this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-article.jpg') }}'; this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                         style="opacity:0;">
                                    <!-- Loading placeholder -->
                                    <div class="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        @if($artikel->artikelKategori)
                                        <span class="bg-orange-500 text-white text-sm font-medium px-3 py-1 rounded-full shadow-lg">
                                            {{ $artikel->artikelKategori->title }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Article Content -->
                                <div class="p-6 flex-1 flex flex-col">
                                    <!-- Title -->
                                    <h3 class="font-bold text-gray-900 text-xl mb-3 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">
                                        {{ $artikel->title }}
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    @if($artikel->content)
                                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-1 leading-relaxed">
                                            {{ Str::limit(strip_tags($artikel->content), 120) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Footer -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 mt-auto pt-4">
                                        <time datetime="{{ $artikel->created_at->toISOString() }}" class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $artikel->created_at->format('d M Y') }}
                                        </time>
                                        <span class="text-orange-500 font-medium flex items-center">
                                            Baca 
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Artikel</h3>
                    <p class="text-gray-600 mb-8 text-lg">{{ $author->name }} belum menulis artikel apapun.</p>
                    <a href="{{ route('artikel') }}" class="inline-flex items-center px-8 py-4 bg-orange-500 text-white font-semibold rounded-xl hover:bg-orange-600 transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        Lihat Artikel Lainnya
                    </a>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Author tidak ditemukan</h1>
            <a href="{{ route('artikel') }}" class="text-orange-500 hover:text-orange-600">Kembali ke Artikel</a>
        </div>
    </div>
@endif
@endsection
