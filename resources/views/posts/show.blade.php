<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Berita</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; color: #333; line-height: 1.6; }
        h1 { color: #2c3e50; margin-bottom: 5px; }
        a { color: #3498db; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn { display: inline-block; background: #3498db; color: white; padding: 8px 12px; border-radius: 4px; margin-top: 20px; }
        .btn:hover { background: #2980b9; text-decoration: none; }
        .content-box { background: #fafafa; padding: 20px; border-radius: 5px; border: 1px solid #ddd; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p style="color: #7f8c8d; margin-top: 0;"><strong>Kategori:</strong> {{ $post->category ? $post->category->name : 'Tanpa Kategori' }}</p>
    
    @if($post->image)
        <div style="margin: 20px 0;">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita" style="max-width: 100%; height: auto; border-radius: 5px;">
        </div>
    @endif

    <div class="content-box">
        <p style="white-space: pre-wrap;">{{ $post->content }}</p>
    </div>
    
    <a href="{{ route('posts.index') }}" class="btn">&larr; Kembali ke Beranda</a>
</body>
</html>
