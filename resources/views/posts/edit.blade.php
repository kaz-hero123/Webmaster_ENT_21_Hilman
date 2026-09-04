<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Berita</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; color: #333; line-height: 1.6; }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        a { color: #7f8c8d; text-decoration: none; font-size: 14px; }
        a:hover { text-decoration: underline; color: #34495e; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #34495e; }
        input[type="text"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: inherit; }
        input[type="file"] { margin-top: 5px; }
        .btn { background: #3498db; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-size: 16px; width: 100%; margin-top: 10px;}
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <a href="{{ route('posts.index') }}">&larr; Kembali ke Daftar Berita</a>
    <h1>Edit Berita</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" style="background: #fafafa; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category_id">Kategori:</label>
            <select name="category_id" id="category_id">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Judul:</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label for="content">Konten:</label>
            <textarea name="content" id="content" rows="6" required>{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Gambar (opsional):</label><br>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Saat Ini" style="max-width: 150px; margin-bottom: 10px;"><br>
            @endif
            <input type="file" name="image" id="image">
        </div>
        <button type="submit" class="btn">Simpan Perubahan</button>
    </form>
</body>
</html>
