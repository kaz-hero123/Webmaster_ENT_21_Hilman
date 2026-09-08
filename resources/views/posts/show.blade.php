<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - PortalBerita</title>
    
    <!-- Meta tags for SEO & Social Sharing -->
    <meta name="description" content="{{ $post->excerpt }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    @if($post->image)
    <meta property="og:image" content="{{ asset('storage/' . $post->image) }}">
    @endif
    <meta property="og:type" content="article">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Simple Navbar for Article Page -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-extrabold text-brand-600 tracking-tighter hover:opacity-80 transition-opacity">
                        Portal<span class="text-gray-900">Berita<span class="text-brand-600">.</span></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-sm font-bold text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="hidden sm:inline">Beranda</span>
                    </a>
                    @auth
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 px-3 py-1.5 rounded-md transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span class="hidden sm:inline">Edit Artikel</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Article Layout -->
    <main class="flex-grow w-full pb-16">
        
        <!-- Breadcrumb & Header Region (Centered) -->
        <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 md:pt-12">
            
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-gray-500 mb-6 font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
                    </li>
                    @if($post->category)
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <a href="{{ route('posts.category', $post->category->slug) }}" class="hover:text-brand-600 transition-colors">{{ $post->category->name }}</a>
                        </div>
                    </li>
                    @endif
                </ol>
            </nav>

            <!-- Article Title & Meta -->
            <header class="mb-8 md:mb-10 text-center sm:text-left">
                @if($post->category)
                <a href="{{ route('posts.category', $post->category->slug) }}" class="inline-block px-3 py-1 mb-4 rounded bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-widest hover:bg-brand-100 transition-colors">
                    {{ $post->category->name }}
                </a>
                @endif
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6 text-balance font-serif">
                    {{ $post->title }}
                </h1>
                
                @if($post->excerpt)
                <p class="text-xl text-gray-600 mb-6 font-medium leading-relaxed">
                    {{ $post->excerpt }}
                </p>
                @endif

                <div class="flex flex-col sm:flex-row items-center justify-between border-y border-gray-100 py-4 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-gray-900">Oleh: {{ $post->author ? $post->author->name : 'Redaksi' }}</p>
                            <div class="flex items-center text-xs text-gray-500 gap-2 mt-1">
                                <time datetime="{{ $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String() }}">
                                    {{ $post->published_at ? $post->published_at->translatedFormat('l, d M Y H:i') : $post->created_at->translatedFormat('l, d M Y H:i') }} WIB
                                </time>
                                <span>&bull;</span>
                                <span>{{ $post->views }}x dilihat</span>
                                <span>&bull;</span>
                                <span>{{ $post->readingTime() }} menit baca</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Share -->
                    <div class="flex gap-2">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#1DA1F2] hover:text-white transition-colors" title="Share ke Twitter">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#1877F2] hover:text-white transition-colors" title="Share ke Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#25D366] hover:text-white transition-colors" title="Share ke WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            @if($post->image)
                <figure class="mb-10 w-full">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-auto max-h-[500px] object-cover rounded-2xl shadow-sm">
                    <figcaption class="mt-3 text-center text-xs text-gray-500 italic">Ilustrasi: {{ $post->title }}</figcaption>
                </figure>
            @endif

            <!-- Article Body (Tailwind Typography Plugin) -->
            <!-- The 'prose' class is magic! It auto-styles all raw HTML content nicely -->
            <div class="prose prose-lg prose-brand max-w-none mb-12 font-serif text-gray-800 leading-relaxed selection:bg-brand-200">
                {!! $post->content !!}
            </div>

            <!-- Tags/Topics (Mockup) -->
            <div class="border-t border-gray-100 pt-6 mb-12">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Topik Terkait</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-brand-50 hover:text-brand-600 text-gray-600 text-sm rounded-full transition-colors">PortalBerita</a>
                    @if($post->category)
                    <a href="{{ route('posts.category', $post->category->slug) }}" class="px-3 py-1 bg-gray-100 hover:bg-brand-50 hover:text-brand-600 text-gray-600 text-sm rounded-full transition-colors">{{ $post->category->name }}</a>
                    @endif
                </div>
            </div>

        </article>

        <!-- Related Articles Section (Full width gray background) -->
        @if($relatedPosts && $relatedPosts->count() > 0)
        <section class="bg-gray-50 border-t border-gray-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Baca Juga</h2>
                    @if($post->category)
                        <a href="{{ route('posts.category', $post->category->slug) }}" class="text-brand-600 font-medium hover:text-brand-800 transition-colors text-sm">Lihat lainnya &rarr;</a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <a href="{{ route('posts.show', $related->slug) }}" class="block relative h-40 overflow-hidden bg-gray-100">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" loading="lazy" class="w-full h-full object-cover">
                                @endif
                            </a>
                            <div class="p-5">
                                <div class="text-xs text-gray-500 mb-2">
                                    {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}
                                </div>
                                <a href="{{ route('posts.show', $related->slug) }}" class="block group">
                                    <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors">
                                        {{ $related->title }}
                                    </h3>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-brand-500 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-800 pb-8 mb-8">
                <span class="text-2xl font-extrabold tracking-tighter">Portal<span class="text-brand-500">Berita<span class="text-white">.</span></span></span>
                <p class="text-sm text-gray-400">Jurnalisme independen yang mencerdaskan bangsa.</p>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} PortalBerita Network. Hak Cipta Dilindungi Undang-Undang.
                </p>
                <div class="flex gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Redaksi</a>
                    <a href="#" class="hover:text-white transition-colors">Kontak</a>
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
