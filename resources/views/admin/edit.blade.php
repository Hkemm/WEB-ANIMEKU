<!DOCTYPE html>
<html>
<head>
    <title>Edit Anime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h2>Edit Anime: {{ $anime->title }}</h2>
        
        <form action="/admin/update/{{ $anime->id }}" method="POST">
            <!-- PENTING DI LARAVEL: CSRF & METHOD PUT -->
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Judul Utama</label>
                    <input type="text" name="title" class="form-control" value="{{ $anime->title }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Judul Jepang</label>
                    <input type="text" name="japan_title" class="form-control" value="{{ $anime->japan_title }}">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $anime->description }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Gambar (Path)</label>
                    <input type="text" name="image" class="form-control" value="{{ $anime->image }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Video Source</label>
                    <input type="text" name="video_source" class="form-control" value="{{ $anime->video_source }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Studio</label>
                    <input type="text" name="studio" class="form-control" value="{{ $anime->studio }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Total Eps</label>
                    <input type="number" name="total_episodes" class="form-control" value="{{ $anime->total_episodes }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Current Eps</label>
                    <input type="text" name="current_ep" class="form-control" value="{{ $anime->current_ep }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="{{ $anime->status }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Rating</label>
                    <input type="text" name="rating" class="form-control" value="{{ $anime->rating }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Genres (Pisahkan dengan koma)</label>
                    <input type="text" name="genres" class="form-control" value="{{ $anime->genres }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ $anime->tags }}">
                </div>
                
                <!-- Field Tambahan (Sembunyikan atau isi jika perlu) -->
                <input type="hidden" name="score" value="{{ $anime->score }}">
                <input type="hidden" name="duration" value="{{ $anime->duration }}">
                <input type="hidden" name="date_aired" value="{{ $anime->date_aired }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="/admin" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>