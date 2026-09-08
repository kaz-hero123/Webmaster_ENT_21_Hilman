<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - Admin PortalBerita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 600,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | image link | help',
            content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px }',
            skin: 'oxide',
            promotion: false,
            branding: false
        });
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen">

    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40 mb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('admin.posts.index') }}" class="text-gray-500 hover:text-gray-900 font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-sm font-medium text-brand-600 hover:text-brand-800 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Post
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-10">
            
            <div class="mb-8 border-b border-gray-100 pb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Berita</h1>
                    <p class="mt-2 text-sm text-gray-500">Perbarui detail berita ini.</p>
                </div>
                <div class="hidden sm:block">
                    @if($post->is_published)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Published
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Draft
                        </span>
                    @endif
                </div>
            </div>

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

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Kolom Utama (Kiri) -->
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') ?? $post->title }}" required class="w-full rounded-md border border-gray-300 py-3 px-4 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-xl font-medium text-gray-900">
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug URL (Otomatis)</label>
                            <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    /berita/
                                </span>
                                <input type="text" disabled value="{{ $post->slug }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 sm:text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-1">Ringkasan (Opsional)</label>
                            <textarea name="excerpt" id="excerpt" rows="2" class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-sm">{{ old('excerpt') ?? $post->excerpt }}</textarea>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Berita <span class="text-red-500">*</span></label>
                            <!-- TinyMCE akan merender div ini -->
                            <textarea name="content" id="content">{{ old('content') ?? $post->content }}</textarea>
                        </div>
                    </div>

                    <!-- Kolom Sidebar (Kanan) -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                            <h3 class="text-sm font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4">Pengaturan Publikasi</h3>
                            
                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category_id" id="category_id" class="w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id') ?? $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6 flex items-center">
                                <input id="is_published" name="is_published" type="checkbox" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900 font-medium">
                                    Published
                                </label>
                            </div>
                            
                            @if($post->published_at)
                                <div class="mb-4 text-xs text-gray-500">
                                    Dipublikasikan pada: <br>
                                    <strong>{{ $post->published_at->format('d M Y H:i') }}</strong>
                                </div>
                            @endif

                            <div class="pt-4 border-t border-gray-200">
                                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                                    Update Berita
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                            <h3 class="text-sm font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4">Media</h3>
                            
                            @if($post->image)
                                <div class="mb-4">
                                    <span class="block text-xs font-medium text-gray-500 mb-2">Gambar Saat Ini:</span>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar" class="w-full h-auto object-cover rounded-md border border-gray-200">
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar</label>
                                <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 bg-white hover:bg-gray-50 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer rounded-md bg-transparent font-medium text-brand-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-500 hover:text-brand-500">
                                                <span>Pilih file baru</span>
                                                <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>

                                <div id="image-preview-container" class="mt-4" style="display: none;">
                                    <div class="relative inline-block w-full">
                                        <img id="image-preview" src="#" alt="Preview" class="w-full h-auto object-cover rounded-md border border-gray-200 shadow-sm">
                                        <button type="button" onclick="cancelImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-sm transition-colors" title="Batal ganti">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(event) {
            if(event.target.files.length > 0) {
                var image = document.getElementById('image-preview');
                image.src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('image-preview-container').style.display = 'block';
            }
        }

        function cancelImage() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').src = '#';
            document.getElementById('image-preview-container').style.display = 'none';
        }
    </script>
</body>
</html>
