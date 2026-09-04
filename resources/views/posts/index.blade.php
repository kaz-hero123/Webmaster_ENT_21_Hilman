<!DOCTYPE html>
<html>
<head>
    <title>Portal Berita</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; color: #333; line-height: 1.6; }
        h1, h2 { color: #2c3e50; }
        a { color: #3498db; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fafafa; }
        button, .btn { background: #3498db; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; font-size: 14px;}
        button:hover, .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .search-box { background: #eee; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        input, select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        hr { border: 0; border-top: 1px solid #eee; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Portal Berita 📰</h1>

    <a href="{{ route('posts.create') }}">+ Tambah Berita Baru</a>

    <hr>

    <div class="search-box">
        <form action="{{ route('posts.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <label>Cari:</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul...">
            
            <label>Kategori:</label>
            <select name="category_id">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Cari</button>
            <a href="{{ route('posts.index') }}">Reset</a>
        </form>
    </div>

    @forelse ($posts as $post)
        <div class="card">
            <h2 style="margin-top: 0;"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
            <p style="font-size: 13px; color: #7f8c8d;"><strong>Kategori:</strong> {{ $post->category ? $post->category->name : 'Tanpa Kategori' }}</p>
            <p>{{ Str::limit($post->content, 120) }}</p>

            <div style="margin-top: 15px;">
                <a href="{{ route('posts.edit', $post->id) }}" class="btn" style="display: inline-block;">Edit</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p>Belum ada berita yang tersedia.</p>
    @endforelse
</body>
</html>
