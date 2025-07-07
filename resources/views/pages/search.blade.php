@extends('layouts.app')

@section('title', 'Hasil Pencarian - EKRAF Jember')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50">
    <!-- Search Header -->
    <div class="bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    <i class="fas fa-search mr-3"></i>
                    Hasil Pencarian
                </h1>
                
                <!-- Enhanced Search Form -->
                <form id="search-form" class="max-w-2xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-500"></i>
                            </div>
                            <input type="text" 
                                   id="search-input"
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Cari produk, artikel, katalog, atau penulis..." 
                                   class="w-full pl-12 pr-4 py-3 bg-white rounded-lg border border-white/20 focus:outline-none focus:ring-2 focus:ring-white focus:border-white text-gray-800 placeholder-gray-500 shadow-lg">
                        </div>
                        
                        <div class="flex gap-2">
                            <select id="search-category" name="category" class="px-4 py-3 bg-white rounded-lg border border-white/20 focus:outline-none focus:ring-2 focus:ring-white text-gray-800 shadow-lg">
                                <option value="all">Semua</option>
                                <option value="artikel">Artikel</option>
                                <option value="katalog">Katalog</option>
                                <option value="product">Produk</option>
                            </select>
                            
                            <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-lg font-medium">
                                <i class="fas fa-search mr-2"></i>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Loading State -->
        <div id="loading-state" class="hidden text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
            <p class="mt-2 text-gray-600">Mencari...</p>
        </div>

        <!-- Search Results Container -->
        <div id="search-results">
            <!-- Initial state will be populated by JavaScript -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const searchCategory = document.getElementById('search-category');
    const loadingState = document.getElementById('loading-state');
    const searchResults = document.getElementById('search-results');
    
    // Get initial query from URL
    const urlParams = new URLSearchParams(window.location.search);
    const initialQuery = urlParams.get('q') || '';
    const initialCategory = urlParams.get('category') || 'all';
    
    // Set initial values
    if (initialQuery) {
        searchInput.value = initialQuery;
        searchCategory.value = initialCategory;
        performSearch(initialQuery, initialCategory);
    } else {
        showEmptyState();
    }
    
    // Handle form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        const category = searchCategory.value;
        
        if (query.length > 0) {
            // Update URL
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('q', query);
            newUrl.searchParams.set('category', category);
            window.history.pushState({}, '', newUrl);
            
            performSearch(query, category);
        }
    });
    
    // Perform search via API
    function performSearch(query, category = 'all') {
        showLoading();
        
        const apiUrl = `/api/search?q=${encodeURIComponent(query)}&type=${category}`;
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    displayResults(data.data, query, category);
                } else {
                    showError(data.message || 'Terjadi kesalahan saat mencari');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Search error:', error);
                showError('Terjadi kesalahan koneksi');
            });
    }
    
    // Display search results
    function displayResults(results, query, category) {
        const articles = results.articles || [];
        const katalogs = results.katalogs || [];
        const products = results.products || [];
        
        const totalResults = articles.length + katalogs.length + products.length;
        
        let html = `
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    Menampilkan hasil untuk: "<span class="text-orange-600">${query}</span>"
                </h2>
                <p class="text-gray-600">
                    Ditemukan ${totalResults} hasil
                    ${category !== 'all' ? `dalam kategori <span class="font-medium">${getCategoryName(category)}</span>` : ''}
                </p>
            </div>
        `;
        
        if (totalResults === 0) {
            html += getNoResultsHtml(query);
        } else {
            // Category tabs
            html += getCategoryTabsHtml(query, category, results);
            
            // Results sections
            html += '<div class="space-y-8">';
            
            if ((category === 'all' || category === 'artikel') && articles.length > 0) {
                html += getArticlesHtml(articles);
            }
            
            if ((category === 'all' || category === 'katalog') && katalogs.length > 0) {
                html += getKatalogsHtml(katalogs);
            }
            
            if ((category === 'all' || category === 'product') && products.length > 0) {
                html += getProductsHtml(products);
            }
            
            html += '</div>';
        }
        
        searchResults.innerHTML = html;
    }
    
    // Helper functions
    function showLoading() {
        loadingState.classList.remove('hidden');
        searchResults.innerHTML = '';
    }
    
    function hideLoading() {
        loadingState.classList.add('hidden');
    }
    
    function showEmptyState() {
        searchResults.innerHTML = `
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Mulai Pencarian Anda</h3>
                <p class="text-gray-500 mb-6">Cari artikel, katalog, atau produk dengan kata kunci di atas.</p>
            </div>
        `;
    }
    
    function showError(message) {
        searchResults.innerHTML = `
            <div class="text-center py-12">
                <div class="text-red-400 mb-4">
                    <i class="fas fa-exclamation-triangle text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-red-600 mb-2">Terjadi Kesalahan</h3>
                <p class="text-gray-500">${message}</p>
            </div>
        `;
    }
    
    function getCategoryName(category) {
        const names = {
            'artikel': 'Artikel',
            'katalog': 'Katalog',
            'product': 'Produk'
        };
        return names[category] || category;
    }
    
    function getCategoryTabsHtml(query, category, results) {
        const articles = results.articles || [];
        const katalogs = results.katalogs || [];
        const products = results.products || [];
        const total = articles.length + katalogs.length + products.length;
        
        return `
            <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200">
                <button onclick="searchWithCategory('${query}', 'all')" 
                        class="px-4 py-2 rounded-t-lg transition-colors ${category === 'all' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                    Semua (${total})
                </button>
                
                ${articles.length > 0 ? `
                    <button onclick="searchWithCategory('${query}', 'artikel')" 
                            class="px-4 py-2 rounded-t-lg transition-colors ${category === 'artikel' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                        Artikel (${articles.length})
                    </button>
                ` : ''}
                
                ${katalogs.length > 0 ? `
                    <button onclick="searchWithCategory('${query}', 'katalog')" 
                            class="px-4 py-2 rounded-t-lg transition-colors ${category === 'katalog' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                        Katalog (${katalogs.length})
                    </button>
                ` : ''}
                
                ${products.length > 0 ? `
                    <button onclick="searchWithCategory('${query}', 'product')" 
                            class="px-4 py-2 rounded-t-lg transition-colors ${category === 'product' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                        Produk (${products.length})
                    </button>
                ` : ''}
            </div>
        `;
    }
    
    function getNoResultsHtml(query) {
        return `
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-500 mb-4">Coba gunakan kata kunci yang berbeda atau lebih umum.</p>
                <div class="text-sm text-gray-500">
                    <p class="mb-2">Tips pencarian:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Periksa ejaan kata kunci</li>
                        <li>Gunakan kata kunci yang lebih umum</li>
                        <li>Coba kategori "Semua" untuk hasil yang lebih luas</li>
                    </ul>
                </div>
            </div>
        `;
    }
    
    function getArticlesHtml(articles) {
        let html = `
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-newspaper text-orange-500 mr-2"></i>
                    Artikel (${articles.length})
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        `;
        
        articles.forEach(artikel => {
            const imageUrl = artikel.image_url || artikel.thumbnail || '/assets/img/default-article.jpg';
            const authorName = (artikel.author && artikel.author.name) ? artikel.author.name : 'Unknown Author';
            const categoryName = (artikel.artikel_kategori && artikel.artikel_kategori.nama) ? artikel.artikel_kategori.nama : '';
            const artikelTitle = artikel.title || 'Artikel';
            const artikelContent = artikel.content || '';
            const artikelSlug = artikel.slug || '';
            const createdAt = new Date(artikel.created_at).toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            html += `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="aspect-video bg-gray-200 overflow-hidden">
                        <img src="${imageUrl}" 
                             alt="${artikelTitle}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='/assets/img/default-article.jpg'">
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-1"></i>
                            ${createdAt}
                            <span class="mx-2">•</span>
                            <i class="fas fa-user mr-1"></i>
                            ${authorName}
                        </div>
                        
                        <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            <a href="/artikels/${artikelSlug}">
                                ${artikelTitle}
                            </a>
                        </h4>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-3">
                            ${artikelContent ? artikelContent.replace(/<[^>]*>/g, '').substring(0, 120) + '...' : ''}
                        </p>
                        
                        ${categoryName ? `
                            <span class="inline-block px-2 py-1 bg-orange-100 text-orange-600 text-xs rounded-full">
                                ${categoryName}
                            </span>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        
        html += '</div></div>';
        return html;
    }
    
    function getKatalogsHtml(katalogs) {
        let html = `
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-store text-orange-500 mr-2"></i>
                    Katalog (${katalogs.length})
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        `;
        
        katalogs.forEach(katalog => {
            const imageUrl = katalog.image_url || katalog.thumbnail || '/assets/img/default-katalog.jpg';
            const subSektorName = (katalog.sub_sektor && katalog.sub_sektor.title) ? katalog.sub_sektor.title : 'Subsektor';
            const katalogTitle = katalog.title || 'Katalog';
            const katalogContent = katalog.content || '';
            const katalogContact = katalog.contact || '';
            const katalogSlug = katalog.slug || '';
            
            html += `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="aspect-video bg-gray-200 overflow-hidden">
                        <img src="${imageUrl}" 
                             alt="${katalogTitle}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='/assets/img/default-katalog.jpg'">
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                            <div class="flex items-center">
                                <i class="fas fa-layer-group mr-1 text-blue-500"></i>
                                <span class="font-medium text-blue-600">${subSektorName}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-store mr-1 text-orange-500"></i>
                                <span class="text-xs font-medium text-orange-600">Katalog</span>
                            </div>
                        </div>
                        
                        <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            <a href="/katalog/detail/${katalogSlug}">
                                ${katalogTitle}
                            </a>
                        </h4>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-3">
                            ${katalogContent ? katalogContent.replace(/<[^>]*>/g, '').substring(0, 120) + '...' : ''}
                        </p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            ${katalogContact ? `
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-1"></i>
                                    ${katalogContact}
                                </div>
                            ` : '<div></div>'}
                            
                            <div class="flex items-center text-orange-600">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                <span class="text-xs font-medium">Lihat Detail</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div></div>';
        return html;
    }
    
    function getProductsHtml(products) {
        let html = `
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-shopping-bag text-orange-500 mr-2"></i>
                    Produk (${products.length})
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        `;
        
        products.forEach(product => {
            const imageUrl = product.image || product.thumbnail || '/assets/img/default-product.jpg';
            const categoryName = (product.business_category && product.business_category.name) ? product.business_category.name : '';
            const productName = product.name || 'Produk';
            const productDescription = product.description || '';
            const ownerName = product.owner_name || 'Owner';
            const price = product.price ? `Rp ${new Intl.NumberFormat('id-ID').format(product.price)}` : '';
            
            // Find the first catalog (owner) for this product
            const ownerKatalog = (product.katalogs && product.katalogs.length > 0) ? product.katalogs[0] : null;
            const produktLink = ownerKatalog ? `/katalog/detail/${ownerKatalog.slug}` : '#';
            const linkClass = ownerKatalog ? 'cursor-pointer' : 'cursor-default';
            const clickHandler = ownerKatalog ? `onclick="window.location.href='${produktLink.replace(/'/g, "\\'")}';"` : '';
            
            html += `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow group ${linkClass}" ${clickHandler}>
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        <img src="${imageUrl}" 
                             alt="${productName}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='/assets/img/default-product.jpg'">
                    </div>
                    
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            ${productName}
                        </h4>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-2">
                            ${productDescription ? productDescription.substring(0, 80) + '...' : ''}
                        </p>
                        
                        <div class="text-sm text-gray-500 mb-2">
                            <i class="fas fa-user mr-1"></i>
                            ${ownerName}
                            ${ownerKatalog ? 
                                '<div class="text-xs text-blue-600 mt-1">' +
                                    '<i class="fas fa-store mr-1"></i>' +
                                    'Lihat Katalog: ' + (ownerKatalog.title || 'Katalog') +
                                '</div>' 
                            : ''}
                        </div>
                        
                        ${price ? 
                            '<div class="text-lg font-bold text-orange-600 mb-2">' +
                                price +
                            '</div>' 
                        : ''}
                        
                        ${categoryName ? 
                            '<span class="inline-block px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded-full">' +
                                categoryName +
                            '</span>' 
                        : ''}
                        
                        ${ownerKatalog ? 
                            '<div class="mt-2 text-xs text-gray-500">' +
                                '<i class="fas fa-click text-gray-400 mr-1"></i>' +
                                'Klik untuk melihat katalog lengkap' +
                            '</div>' 
                        : ''}
                    </div>
                </div>
            `;
        });
        
        html += '</div></div>';
        return html;
    }
    
    // Global function for category tabs
    window.searchWithCategory = function(query, category) {
        searchCategory.value = category;
        performSearch(query, category);
        
        // Update URL
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('q', query);
        newUrl.searchParams.set('category', category);
        window.history.pushState({}, '', newUrl);
    };
});
</script>
@endsection
