<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50 mb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('admin.posts.index') }}" class="text-gray-500 hover:text-gray-900 font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sm:p-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Tulis Berita Baru</h1>

            @if($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Ada kesalahan pada form:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-lg">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="10" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Sampul (Opsional)</label>
                    <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="image" class="relative cursor-pointer rounded-md bg-white font-medium text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-blue-500 px-1">
                                    <span>Pilih file</span>
                                    <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    <!-- Image Preview Container -->
                    <div id="image-preview-container" class="mt-4" style="display: none;">
                        <span class="block text-xs font-medium text-gray-500 mb-1">Preview Gambar:</span>
                        <img id="image-preview" src="#" alt="Preview" class="h-48 w-auto object-cover rounded-md border border-gray-200 shadow-sm">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Terbitkan Berita
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Versi sangat simpel untuk level pemula
        function previewImage(event) {
            var image = document.getElementById('image-preview');
            image.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('image-preview-container').style.display = 'block';
        }
    </script>
</body>
</html>
