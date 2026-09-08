<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortalBerita - Sumber Informasi Terpercaya</title>
    <!-- Vite: Load Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-white text-gray-800 font-sans antialiased flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <!-- Top Bar (Optional, for date or breaking news ticker) -->
        <div class="bg-brand-900 text-white text-xs py-1.5 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="hidden sm:block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-brand-200 transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-brand-200 transition-colors">Kontak</a>
                <a href="#" class="hover:text-brand-200 transition-colors">Redaksi</a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-3xl font-extrabold text-brand-600 tracking-tighter">
                        Portal<span class="text-gray-900">Berita<span class="text-brand-600">.</span></span>
                    </a>
                </div>

                <!-- Desktop Nav Categories -->
                <nav class="hidden md:flex space-x-1 lg:space-x-4">
                    <a href="{{ url('/') }}" class="px-3 py-2 text-sm font-bold {{ request()->routeIs('posts.index') && !isset($category) ? 'text-brand-600 border-b-2 border-brand-600' : 'text-gray-700 hover:text-brand-600 transition-colors' }}">
                        Terbaru
                    </a>
                    @foreach($categories->take(5) as $navCategory)
                        <a href="{{ route('posts.category', $navCategory->slug) }}" class="px-3 py-2 text-sm font-bold {{ isset($category) && $category->id == $navCategory->id ? 'text-brand-600 border-b-2 border-brand-600' : 'text-gray-700 hover:text-brand-600 transition-colors' }}">
                            {{ $navCategory->name }}
                        </a>
                    @endforeach
                </nav>

                <!-- Search & Auth -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Search Form Dropdown/Expandable (Simplified for now) -->
                    <form action="{{ route('posts.index') }}" method="GET" class="hidden sm:flex relative">
                        <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}" class="w-48 lg:w-64 pl-4 pr-10 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm bg-gray-50">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-brand-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    @auth
                    <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-gray-700 hover:text-brand-600 flex items-center gap-1 bg-gray-100 px-3 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="hidden sm:inline">Admin</span>
                    </a>
                    @else
                    <!-- Login Button Hidden for normal users, only for journalists/admins -->
                    @endauth
                    
                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500">
                        <span class="sr-only">Open menu</span>
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu (Alpine.js) -->
        <div x-show="mobileMenuOpen" x-collapse x-cloak class="md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-bold {{ request()->routeIs('posts.index') && !isset($category) ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">Terbaru</a>
                @foreach($categories as $navCategory)
                    <a href="{{ route('posts.category', $navCategory->slug) }}" class="block px-3 py-2 rounded-md text-base font-bold {{ isset($category) && $category->id == $navCategory->id ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">{{ $navCategory->name }}</a>
                @endforeach
            </div>
            
            <!-- Mobile Search -->
            <div class="px-5 py-4 border-t border-gray-200">
                <form action="{{ route('posts.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}" class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm bg-gray-50">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-grow pb-16">
        
        <!-- Filter Header (If searching or viewing category) -->
        @if(request('search') || isset($category))
        <div class="bg-gray-100 border-b border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if(request('search'))
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Hasil pencarian untuk: <span class="text-brand-600">"{{ request('search') }}"</span></h1>
                @endif
                
                @if(isset($category))
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 capitalize">{{ $category->name }}</h1>
                @endif
                
                <p class="mt-2 text-sm text-gray-500">Ditemukan {{ $posts->total() }} berita</p>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Main Content Column -->
                <div class="lg:w-2/3">
                    
                    <!-- Hero Section / Featured Post (Only show on homepage without search) -->
                    @if(isset($featuredPost) && !request('search') && !isset($category))
                    <div class="mb-12">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                            <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wider">Sorotan Utama</h2>
                        </div>
                        
                        <article class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <a href="{{ route('posts.show', $featuredPost->slug) }}" class="block">
                                <div class="relative w-full h-64 sm:h-80 md:h-96 bg-gray-200 overflow-hidden">
                                    @if($featuredPost->image)
                                        <img src="{{ asset('storage/' . $featuredPost->image) }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-800">
                                            <span class="text-gray-400 font-medium">PortalBerita</span>
                                        </div>
                                    @endif
                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                                    
                                    <!-- Content over image -->
                                    <div class="absolute bottom-0 left-0 w-full p-6 sm:p-8">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-600 text-white uppercase tracking-wider">
                                                {{ $featuredPost->category ? $featuredPost->category->name : 'Berita' }}
                                            </span>
                                            <span class="text-gray-300 text-sm font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $featuredPost->published_at ? $featuredPost->published_at->diffForHumans() : $featuredPost->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight group-hover:text-brand-300 transition-colors text-balance">
                                            {{ $featuredPost->title }}
                                        </h3>
                                        <p class="mt-3 text-gray-200 line-clamp-2 text-sm sm:text-base hidden sm:block">
                                            {{ $featuredPost->excerpt }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </article>
                    </div>
                    @endif

                    <!-- Grid Berita Terbaru -->
                    <div>
                        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
                            <h2 class="text-2xl font-bold text-gray-900">Berita Terbaru</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse ($posts as $post)
                                <article class="group flex flex-col bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="block relative h-48 overflow-hidden bg-gray-100">
                                        @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-white text-brand-600 shadow-sm">
                                                {{ $post->category ? $post->category->name : 'Berita' }}
                                            </span>
                                        </div>
                                    </a>
                                    
                                    <div class="p-5 flex-1 flex flex-col">
                                        <div class="flex items-center text-xs text-gray-500 mb-2 gap-2">
                                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $post->readingTime() }} min read</span>
                                        </div>
                                        
                                        <a href="{{ route('posts.show', $post->slug) }}" class="block flex-1 group-hover:text-brand-600 transition-colors">
                                            <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 mb-2">
                                                {{ $post->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 line-clamp-3">
                                                {{ $post->excerpt }}
                                            </p>
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="col-span-full py-12 text-center bg-gray-50 rounded-xl border border-gray-200 border-dashed">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada berita</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada berita yang diterbitkan atau cocok dengan filter Anda.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($posts->hasPages())
                            <div class="mt-10 border-t border-gray-200 pt-6">
                                {{ $posts->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Sidebar Column -->
                <aside class="lg:w-1/3 space-y-10">
                    
                    <!-- Search Widget -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 sm:hidden">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Pencarian</h3>
                        <form action="{{ route('posts.index') }}" method="GET" class="relative">
                            <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}" class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-sm">
                            <button type="submit" class="absolute right-0 top-0 mt-3 mr-3 text-gray-400 hover:text-brand-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Trending / Popular (Simulated with recent for now) -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Pilihan Editor</h3>
                        <div class="space-y-6">
                            @foreach($popularPosts->take(4) as $index => $rp)
                                <a href="{{ route('posts.show', $rp->slug) }}" class="group flex gap-4 items-start">
                                    <span class="text-3xl font-extrabold text-gray-200 group-hover:text-brand-300 transition-colors">0{{ $index + 1 }}</span>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-brand-600 transition-colors leading-snug line-clamp-2">{{ $rp->title }}</h4>
                                        <span class="text-xs text-gray-500 mt-1 block">
                                            {{ $rp->published_at ? $rp->published_at->format('d M Y') : $rp->created_at->format('d M Y') }} &bull; {{ $rp->views }} tayangan
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Topik Hangat</h3>
                        <div class="space-y-3">
                            @foreach($sidebarCategories as $cat)
                                <a href="{{ route('posts.category', $cat->slug) }}" class="flex justify-between items-center group">
                                    <span class="text-gray-600 group-hover:text-brand-600 font-medium transition-colors">{{ $cat->name }}</span>
                                    <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">{{ $cat->posts_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter or Ad Space Placeholder -->
                    <div class="bg-brand-600 p-6 rounded-xl text-white text-center shadow-md">
                        <svg class="w-8 h-8 mx-auto mb-3 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <h3 class="text-lg font-bold mb-2">Langganan Newsletter</h3>
                        <p class="text-brand-100 text-sm mb-4">Dapatkan berita pilihan langsung ke inbox Anda setiap pagi.</p>
                        <form class="space-y-2">
                            <input type="email" placeholder="Alamat Email" class="w-full px-4 py-2 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-white">
                            <button type="button" class="w-full bg-gray-900 text-white font-bold px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition-colors">Daftar</button>
                        </form>
                    </div>

                </aside>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-brand-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <span class="text-3xl font-extrabold tracking-tighter">Portal<span class="text-brand-500">Berita<span class="text-white">.</span></span></span>
                    <p class="text-gray-400 mt-4 text-sm max-w-sm leading-relaxed">
                        Menyajikan informasi akurat, terkini, dan berimbang. Mengedepankan jurnalisme independen yang mencerdaskan bangsa.
                    </p>
                    <div class="flex gap-4 mt-6">
                        <!-- Social Icons -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-brand-600 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        @foreach($categories->take(5) as $cat)
                            <li><a href="{{ route('posts.category', $cat->slug) }}" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-4">Perusahaan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Redaksi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Pedoman Media Siber</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Disclaimer</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 text-sm transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} PortalBerita Network. Hak Cipta Dilindungi Undang-Undang.
                </p>
                <div class="flex gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
