@extends('layouts.app')
@section('title', 'EKRAF KUNINGAN')

@section('content')
    <div class="relative h-44 md:h-15 bg-center bg-cover flex items-center"
        style="background-image: url('{{ secure_asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > Katalog
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">KATALOG</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex space-x-2 mb-4 md:mb-0">
                <a href="{{ route('katalog') }}"
                    class="flex items-center px-4 py-1 border rounded-full text-sm hover:bg-orange-500 hover:text-white 
            {{ !request('sort') ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <i class="fas fa-list mr-2"></i> Semua
                </a>
                <a href="{{ route('katalog', ['sort' => 'terbaru', 'subsektor' => request('subsektor')]) }}"
                    class="flex items-center px-4 py-1 border rounded-full text-sm hover:bg-orange-500 hover:text-white 
                {{ request('sort') == 'terbaru' ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <i class="fas fa-clock mr-2"></i> Terbaru
                </a>
            </div>

            <form method="GET" class="flex items-center space-x-2">
                <select name="subsektor" onchange="this.form.submit()" class="border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="">Pilih Sub Sektor</option>
                    @foreach ($subsektors as $sub)
                        <option value="{{ $sub->id }}" {{ request('subsektor') == $sub->id ? 'selected' : '' }}>
                            {{ $sub->title }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($katalogs as $katalog)
                <a href="{{ route('katalog.show', $katalog->slug) }}" class="block">
                    <div class="catalog-card">
                        <!-- Image Container -->
                        <div class="catalog-card-image">
                            <img src="{{ $katalog->image_url }}" 
                                 alt="{{ $katalog->title }}"
                                 class="w-full h-full object-cover transition-opacity duration-300"
                                 onload="this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                 onerror="this.onerror=null; this.src='{{ secure_asset('assets/img/placeholder-catalog.jpg') }}'; this.style.opacity='1'; this.nextElementSibling.style.display='none';"
                                 style="opacity:0;">
                            <!-- Loading placeholder -->
                            <div class="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Content Container -->
                        <div class="catalog-card-content">
                            <!-- Title -->
                            <h3 class="catalog-card-title">
                                {{ $katalog->title }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="catalog-card-description">
                                {{ Str::limit(strip_tags($katalog->content), 120) }}
                            </p>
                            
                            <!-- Footer -->
                            <div class="catalog-card-footer">
                                <span class="inline-block bg-orange-50 text-orange-600 text-xs px-3 py-1 rounded-full font-medium border border-orange-200">
                                    {{ $katalog->subSektor->title ?? '-' }}
                                </span>
                                @if($katalog->products_count > 0)
                                    <span class="text-xs text-gray-500 font-medium">
                                        <i class="fas fa-box-open mr-1"></i>{{ $katalog->products_count }} produk
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>

            @empty
                <div class="col-span-3 text-center text-gray-500">Data katalog tidak ditemukan.</div>
            @endforelse
        </div>

        {{-- Info kecil --}}
        <div class="text-center text-xs text-gray-600 mt-6">
            Menampilkan {{ $katalogs->count() }} dari total {{ $katalogs->total() }} katalog
        </div>

        {{-- Numbered pagination --}}
        <div class="mt-4 flex justify-center">
            {{ $katalogs->onEachSide(1)->links() }}
        </div>
    </div>
    {{-- Yuk beres  yuk--}}
@endsection
