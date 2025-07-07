@extends('layouts.app')
@section('title', $katalog->title)

@section('content')
    <!-- Banner -->
    <div class="relative h-44 md:h-64 bg-center bg-cover flex items-center"
        style="background-image: url('{{ secure_asset('assets/img/Katalog.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > <a href="/katalog" class="hover:underline">Katalog</a> >
                {{ $katalog->title }}
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">{{ $katalog->title }}</h1>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="grid md:grid-cols-2 gap-8 mb-8 items-start">
            <div class="bg-white rounded-2xl p-6 shadow border text-gray-700">
                <h2 class="text-lg font-bold text-orange-600 mb-2">{{ $katalog->title ?? 'Judul tidak tersedia' }}</h2>
                <p class="text-sm leading-relaxed mb-6">
                    {!! $katalog->content ?? 'Deskripsi katalog tidak tersedia.' !!}
                </p>

                <h3 class="text-orange-500 font-bold text-md mb-2">Sub Sektor</h3>
                <p class="text-sm mb-4">{{ $katalog->subSektor->title ?? 'Sub sektor tidak tersedia' }}</p>

                @if($katalog->products->count() > 0)
                    <h3 class="text-orange-500 font-bold text-md mb-2">Produk Terkait</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $katalog->products->count() }} produk tersedia dalam katalog ini</p>
                @endif

                <!-- Kontak Informasi -->
                @if($katalog->contact || $katalog->phone_number || $katalog->email || $katalog->instagram || $katalog->shopee || $katalog->tokopedia || $katalog->lazada)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-orange-500 font-bold text-md mb-3">Informasi Kontak</h3>
                        
                        @if($katalog->contact)
                            <div class="mb-2">
                                <span class="text-xs text-gray-500">Kontak:</span>
                                <p class="text-sm">{{ $katalog->contact }}</p>
                            </div>
                        @endif
                        
                        @if($katalog->phone_number)
                            <div class="mb-2">
                                <span class="text-xs text-gray-500">Nomor Telepon:</span>
                                <p class="text-sm">{{ $katalog->phone_number }}</p>
                                <a href="https://wa.me/62{{ $katalog->phone_number }}" target="_blank"
                                   class="inline-flex items-center text-green-600 hover:text-green-800 transition text-sm mt-1">
                                    <i class="fab fa-whatsapp mr-1"></i>
                                    Chat WhatsApp
                                </a>
                            </div>
                        @endif
                        
                        @if($katalog->email)
                            <div class="mb-3">
                                <span class="text-xs text-gray-500">Email:</span>
                                <p class="text-sm">
                                    <a href="mailto:{{ $katalog->email }}" class="text-blue-600 hover:text-blue-800 transition">
                                        {{ $katalog->email }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        <!-- Media Sosial & Toko Online -->
                        @if($katalog->instagram || $katalog->shopee || $katalog->tokopedia || $katalog->lazada)
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <h4 class="text-orange-400 font-semibold text-sm mb-2">Media Sosial & Toko Online</h4>
                                <div class="flex flex-wrap gap-2">
                                    @if($katalog->instagram)
                                        <a href="{{ $katalog->instagram }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:from-purple-600 hover:to-pink-600 transition">
                                            <i class="fab fa-instagram mr-1"></i>
                                            Instagram
                                        </a>
                                    @endif
                                    
                                    @if($katalog->shopee)
                                        <a href="{{ $katalog->shopee }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">
                                            <i class="fas fa-shopping-bag mr-1"></i>
                                            Shopee
                                        </a>
                                    @endif
                                    
                                    @if($katalog->tokopedia)
                                        <a href="{{ $katalog->tokopedia }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-green-500 text-white rounded-full hover:bg-green-600 transition">
                                            <i class="fas fa-store mr-1"></i>
                                            Tokopedia
                                        </a>
                                    @endif
                                    
                                    @if($katalog->lazada)
                                        <a href="{{ $katalog->lazada }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Lazada
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <img src="{{ $katalog->image_url }}" alt="{{ $katalog->title }}"
                    class="rounded-2xl shadow w-full object-cover">
            </div>
        </div>

        <!-- Produk Terkait -->
        @if($katalog->products->count() > 0)
        <section class="mb-12">
            <h2 class="text-xl font-bold text-orange-600 mb-6">Produk Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($katalog->products as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover">

                        <!-- Category Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-block bg-white/90 backdrop-blur text-xs px-2 py-1 rounded-full font-medium text-gray-700 shadow-sm">
                                {{ $product->businessCategory->name ?? 'Kategori' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4 space-y-3">
                        <!-- Product Name -->
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium">
                                <i class="fas fa-user text-[10px] mr-1"></i>
                                {{ $product->owner_name }}
                            </p>
                        </div>
                        
                        <!-- Price & Stock -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-600 font-bold text-sm">
                                    {{ $product->price ? 'Rp ' . number_format($product->price, 0, ',', '.') : 'Hubungi Penjual' }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        @if($product->description)
                            <p class="text-xs text-gray-600 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($product->description), 80) }}
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

    </div>

    <!-- Produk Lainnya -->
    <section class="max-w-7xl mx-auto pb-12 px-6">
        <h2 class="text-center text-orange-500 font-semibold text-md mb-8">Katalog Lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
            @foreach ($others as $kat)
                <a href="{{ route('katalog.show', $kat->slug) }}">
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition transform hover:scale-105 duration-300">
                        <img src="{{ $kat->image_url }}" alt="{{ $kat->title }}"
                            class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-base font-bold text-orange-600 mb-1">{{ $kat->title }}</h3>
                            <p class="text-xs text-gray-600 mb-3">{{ Str::limit(strip_tags($kat->content), 80) }}</p>
                            <span class="inline-block bg-gray-100 text-[10px] px-2 py-1 rounded-full">
                                {{ $kat->subSektor->title ?? '-' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
