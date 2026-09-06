<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita</title>
    <!-- Vite: Load Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 tracking-tight">
                        Portal<span class="text-gray-900">Berita</span>
                    </a>
                </div>
                @auth
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                        + Tambah Berita Baru
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-900">Logout</button>
                    </form>
                </div>
                @else
                <div>
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">
                        Login Admin
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header & Search Section -->
    <div class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                Temukan Berita Terkini
            </h1>
            
            <form action="{{ url()->current() }}" method="GET" class="max-w-5xl mx-auto bg-white p-2 rounded-lg shadow-lg flex flex-col md:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." class="flex-1 px-4 py-3 border-none focus:ring-0 text-gray-900 rounded-md bg-gray-50 outline-none w-full">
                
                <div class="flex flex-col sm:flex-row gap-2 md:w-auto w-full">
                    <select name="category_id" class="px-4 py-3 border-none focus:ring-0 text-gray-900 bg-gray-50 rounded-md outline-none w-full sm:w-40 border-t sm:border-t-0 sm:border-l border-gray-200">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" class="px-4 py-3 border-none focus:ring-0 text-gray-900 bg-gray-50 rounded-md outline-none w-full sm:w-36 border-t sm:border-t-0 sm:border-l border-gray-200">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors w-full sm:w-auto">
                        Cari
                    </button>
                    @if(request('search') || request('category_id') || request('sort'))
                        <a href="{{ url()->current() }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-md transition-colors w-full sm:w-auto text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Berita Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Berita Terbaru</h2>
            <span class="text-sm text-gray-500">Menampilkan {{ $posts->count() }} berita</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($posts as $post)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar" class="w-full h-48 object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-48 bg-gray-200 flex items-center justify-center\'><span class=\'text-gray-400 text-sm\'>Gambar Tidak Ditemukan</span></div>';">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Tanpa Gambar</span>
                        </div>
                    @endif
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $post->category ? $post->category->name : 'Uncategorized' }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <a href="{{ route('posts.show', $post->id) }}" class="block mb-3 flex-1 group">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-gray-600 line-clamp-3 text-sm">
                                {{ strip_tags($post->content) }}
                            </p>
                        </a>
                        
                        @auth
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-3 items-center">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus berita ini permanen?')" class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-xl border border-gray-100 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada berita</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada berita yang diterbitkan atau cocok dengan pencarian.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
