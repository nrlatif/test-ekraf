<!-- Enhanced Responsive Navbar -->
<nav class="w-full">
    <div class="sticky top-0 z-50 bg-gradient-to-r from-yellow-300 via-yellow-400 to-orange-500 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-18">
                <!-- Logo Section -->
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo"
                            class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 transition-transform duration-300 hover:scale-105">
                    </a>
                </div>

                <!-- Desktop Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-4 lg:mx-8">
                    <form id="desktop-search-form" class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-green-700 text-sm"></i>
                        </div>
                        <input type="text" name="q" id="desktop-search"
                            placeholder="Cari produk, artikel, atau informasi..."
                            class="w-full pl-10 pr-12 py-2 bg-gradient-to-r from-yellow-200 via-yellow-300 to-orange-200 text-green-900 placeholder-green-700 font-medium rounded-full text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-white border border-white/50 transition-all duration-300">
                        <button type="submit"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-green-700 hover:text-green-800 transition-colors">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('landing') }}"
                        class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}">
                        <i class="fas fa-home mr-1"></i>
                        <span>HOME</span>
                    </a>
                    <a href="{{ route('katalog') }}"
                        class="nav-link {{ request()->routeIs('katalog*') ? 'active' : '' }}">
                        <i class="fas fa-store mr-1"></i>
                        <span>KATALOG</span>
                    </a>
                    <a href="{{ route('artikel') }}"
                        class="nav-link {{ request()->routeIs('artikel*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper mr-1"></i>
                        <span>ARTIKEL</span>
                    </a>
                    <a href="{{ route('kontak') }}" class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">
                        <i class="fas fa-phone mr-1"></i>
                        <span>KONTAK</span>
                    </a>

                    @auth
                        <!-- User Menu -->
                        <div class="relative group">
                            <button
                                class="flex items-center space-x-2 px-3 py-2 bg-white/20 rounded-full hover:bg-white/30 transition-all duration-200">
                                <i class="fas fa-user-circle text-white text-lg"></i>
                                <span
                                    class="text-white font-medium text-sm">{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <i
                                    class="fas fa-chevron-down text-white text-xs group-hover:rotate-180 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                                <div class="py-2">
                                    @if (auth()->user()->level_id === 1 || auth()->user()->level_id === 2)
                                        <a href="{{ route('filament.admin.pages.dashboard') }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                            <i class="fas fa-tachometer-alt mr-3 text-orange-500"></i>
                                            Dashboard Admin
                                        </a>
                                        <div class="border-t border-gray-100 my-1"></div>
                                    @endif

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-3"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 px-4 py-2 bg-white text-orange-600 rounded-full hover:bg-orange-50 hover:shadow-md transition-all duration-200 font-medium text-sm">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>LOGIN</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center space-x-2 lg:hidden">
                    <!-- Mobile Search Toggle -->
                    <button id="search-toggle"
                        class="p-2 text-white hover:bg-white/20 rounded-lg transition-colors md:hidden">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- Enhanced Hamburger Menu -->
                    <button id="mobile-menu-toggle"
                        class="relative p-2 text-white hover:bg-white/20 rounded-lg transition-all duration-300 focus:outline-none group">
                        <div class="w-6 h-6 flex flex-col justify-center items-center">
                            <span
                                class="hamburger-line hamburger-line-1 block w-6 h-0.5 bg-white transition-all duration-300 ease-in-out"></span>
                            <span
                                class="hamburger-line hamburger-line-2 block w-6 h-0.5 bg-white transition-all duration-300 ease-in-out mt-1.5"></span>
                            <span
                                class="hamburger-line hamburger-line-3 block w-6 h-0.5 bg-white transition-all duration-300 ease-in-out mt-1.5"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div id="mobile-search"
            class="md:hidden hidden bg-white/95 backdrop-blur-sm px-4 py-3 border-t border-orange-200">
            <form id="mobile-search-form" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-green-700"></i>
                </div>
                <input type="text" name="q" id="mobile-search-input"
                    placeholder="Cari produk, artikel, atau informasi..."
                    class="w-full pl-10 pr-12 py-3 bg-gradient-to-r from-yellow-200 via-yellow-300 to-orange-200 text-green-900 placeholder-green-700 font-medium rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 border border-white/50">
                <button type="submit"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-green-700 hover:text-green-800 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- Enhanced Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white/98 backdrop-blur-sm border-t border-orange-200">
            <div class="px-4 py-3 space-y-1">
                <!-- Navigation Links -->
                <a href="{{ route('landing') }}"
                    class="mobile-nav-link {{ request()->routeIs('landing') ? 'active' : '' }}">
                    <i class="fas fa-home w-5 text-orange-500"></i>
                    <span class="font-medium">HOME</span>
                </a>
                <a href="{{ route('katalog') }}"
                    class="mobile-nav-link {{ request()->routeIs('katalog*') ? 'active' : '' }}">
                    <i class="fas fa-store w-5 text-orange-500"></i>
                    <span class="font-medium">KATALOG</span>
                </a>
                <a href="{{ route('artikel') }}"
                    class="mobile-nav-link {{ request()->routeIs('artikel*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper w-5 text-orange-500"></i>
                    <span class="font-medium">ARTIKEL</span>
                </a>
                <a href="{{ route('kontak') }}"
                    class="mobile-nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">
                    <i class="fas fa-phone w-5 text-orange-500"></i>
                    <span class="font-medium">KONTAK</span>
                </a>

                @auth
                    <!-- User Section -->
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex items-center space-x-3 px-3 py-2 bg-orange-50 rounded-lg mb-3">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        @if (auth()->user()->level_id === 1 || auth()->user()->level_id === 2)
                            <a href="{{ route('filament.admin.pages.dashboard') }}" class="mobile-nav-link admin">
                                <i class="fas fa-tachometer-alt w-5 text-blue-500"></i>
                                <span class="font-medium">DASHBOARD ADMIN</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="mobile-nav-link logout w-full text-left">
                                <i class="fas fa-sign-out-alt w-5 text-red-500"></i>
                                <span class="font-medium">LOGOUT</span>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Login Section -->
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center space-x-2 px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all duration-200 font-medium">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>LOGIN</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
</nav>

<!-- Enhanced Responsive Navbar Styles -->
<style>
    /* Desktop Navigation Links */
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        /* text-sm */
        font-weight: 500;
        color: #065f46;
        /* text-green-900 */
        transition: all 0.2s;
        padding: 0.5rem 0.75rem;
        /* px-3 py-2 */
        border-radius: 0.5rem;
        /* rounded-lg */
    }

    .nav-link:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .nav-link.active {
        color: white;
        background-color: rgba(255, 255, 255, 0.2);
    }

    /* Mobile Navigation Links */
    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        color: #374151;
        /* text-gray-700 */
        border-radius: 0.5rem;
        transition: all 0.2s;
    }

    .mobile-nav-link:hover {
        background-color: #fff7ed;
        /* hover:bg-orange-50 */
        color: #ea580c;
        /* hover:text-orange-600 */
    }

    .mobile-nav-link.active {
        background-color: #ffedd5;
        /* bg-orange-100 */
        color: #ea580c;
        font-weight: 500;
    }

    .mobile-nav-link.admin:hover {
        background-color: #eff6ff;
        color: #2563eb;
    }

    .mobile-nav-link.logout:hover {
        background-color: #fef2f2;
        color: #dc2626;
    }

    /* Search input hover */
    input:hover {
        outline: 2px solid #fb923c;
        /* ring-2 ring-orange-300 */
        outline-offset: 0px;
    }
</style>



<!-- Enhanced JavaScript for Responsive Navbar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const searchToggle = document.getElementById('search-toggle');
        const mobileSearch = document.getElementById('mobile-search');

        // Create backdrop element
        const backdrop = document.createElement('div');
        backdrop.className = 'mobile-menu-backdrop hidden';
        backdrop.id = 'mobile-menu-backdrop';
        document.body.appendChild(backdrop);

        // Enhanced Mobile Menu Toggle with Smooth Animation
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isMenuOpen = !mobileMenu.classList.contains('hidden');

            if (isMenuOpen) {
                // Close menu
                closeMenu();
            } else {
                // Open menu
                openMenu();
            }
        });

        // Enhanced Mobile Search Toggle
        if (searchToggle) {
            searchToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isSearchOpen = !mobileSearch.classList.contains('hidden');

                if (isSearchOpen) {
                    mobileSearch.classList.add('hidden');
                } else {
                    mobileSearch.classList.remove('hidden');
                    // Focus input after animation
                    setTimeout(() => {
                        const input = mobileSearch.querySelector('input');
                        if (input) input.focus();
                    }, 200);
                }
            });
        }

        // Open Menu Function
        function openMenu() {
            document.body.classList.add('menu-open');
            mobileMenu.classList.remove('hidden');
            backdrop.classList.remove('hidden');

            // Prevent body scroll
            document.body.style.overflow = 'hidden';

            // Add escape key listener
            document.addEventListener('keydown', handleEscapeKey);
        }

        // Close Menu Function
        function closeMenu() {
            document.body.classList.remove('menu-open');

            // Delay hiding for smooth animation
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 100);

            backdrop.classList.add('hidden');

            // Restore body scroll
            document.body.style.overflow = '';

            // Remove escape key listener
            document.removeEventListener('keydown', handleEscapeKey);
        }

        // Handle Escape Key
        function handleEscapeKey(e) {
            if (e.key === 'Escape') {
                closeMenu();
                if (!mobileSearch.classList.contains('hidden')) {
                    mobileSearch.classList.add('hidden');
                }
            }
        }

        // Enhanced Click Outside to Close
        backdrop.addEventListener('click', closeMenu);

        document.addEventListener('click', function(event) {
            // Close search if clicking outside
            if (mobileSearch && !mobileSearch.classList.contains('hidden')) {
                const isClickInsideSearch = mobileSearch.contains(event.target) ||
                    (searchToggle && searchToggle.contains(event.target));

                if (!isClickInsideSearch) {
                    mobileSearch.classList.add('hidden');
                }
            }
        });

        // Close Mobile Menu on Window Resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (window.innerWidth >= 1024) {
                    closeMenu();
                    if (mobileSearch) {
                        mobileSearch.classList.add('hidden');
                    }
                }
            }, 150);
        });

        // Enhanced Search Functionality
        const searchInputs = document.querySelectorAll('input[placeholder*="Cari"]');
        searchInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && this.value.trim()) {
                    // Implement search functionality here
                    console.log('Searching for:', this.value.trim());
                    // Example: window.location.href = `/search?q=${encodeURIComponent(this.value.trim())}`;
                }
            });

            // Add input animation
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-orange-400');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-orange-400');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    if (!mobileMenu.classList.contains('hidden')) {
                        closeMenu();
                    }
                }
            });
        });

        // Add loading states for navigation links
        document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (this.href && !this.href.includes('#')) {
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';

                    // Reset after a delay (in case navigation fails)
                    setTimeout(() => {
                        this.style.opacity = '';
                        this.style.pointerEvents = '';
                    }, 3000);
                }
            });
        });

        // Enhanced search functionality
        const desktopSearch = document.getElementById('desktop-search');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const desktopSearchForm = document.getElementById('desktop-search-form');
        const mobileSearchForm = document.getElementById('mobile-search-form');

        // Handle search form submissions
        function handleSearchSubmit(e, input) {
            e.preventDefault();
            const query = input.value.trim();

            if (query) {
                // Redirect to search page with query
                window.location.href = `/search?q=${encodeURIComponent(query)}`;
            }
        }

        if (desktopSearchForm) {
            desktopSearchForm.addEventListener('submit', function(e) {
                handleSearchSubmit(e, desktopSearch);
            });
        }

        if (mobileSearchForm) {
            mobileSearchForm.addEventListener('submit', function(e) {
                handleSearchSubmit(e, mobileSearchInput);
            });
        }

        // Auto-submit on Enter key and visual feedback
        [desktopSearch, mobileSearchInput].forEach(input => {
            if (input) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = `/search?q=${encodeURIComponent(query)}`;
                        }
                    }
                });

                // Add search suggestions (visual feedback)
                input.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    if (query.length > 0) {
                        this.style.borderColor = '#10b981';
                    } else {
                        this.style.borderColor = '';
                    }
                });
            }
        });
    });
</script>
