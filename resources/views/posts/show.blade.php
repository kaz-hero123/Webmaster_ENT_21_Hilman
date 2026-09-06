<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Portal Berita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 tracking-tight flex items-center gap-2 hover:text-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
                @auth
                <div class="flex items-center gap-4">
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

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($post->image)
                <div class="w-full h-[400px] bg-gray-100">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center\'><span class=\'text-gray-400\'>Gambar Tidak Ditemukan</span></div>';">
                </div>
            @endif

            <div class="p-8 sm:p-12">
                <div class="flex items-center gap-4 mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        {{ $post->category ? $post->category->name : 'Uncategorized' }}
                    </span>
                    <span class="text-sm text-gray-500 font-medium">
                        Diterbitkan {{ $post->created_at->format('d M Y') }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-8">
                    {{ $post->title }}
                </h1>

                <div class="prose prose-lg prose-blue max-w-none text-gray-700 whitespace-pre-wrap">
                    {{ $post->content }}
                </div>
                
                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        &larr; Baca berita lainnya
                    </a>
                    
                    @auth
                    <div class="flex gap-4">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm font-medium transition-colors">
                            Edit
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
        </article>
    </main>
    
    <footer class="bg-white border-t border-gray-100 py-8 mt-auto">
        <div class="max-w-4xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Portal Berita. Dibuat untuk keperluan evaluasi.
        </div>
    </footer>

</body>
</html>
