<!DOCTYPE html>
<html>
<head>
    <title>Upload Gambar</title>
</head>
<body>
    <h2>Upload dan Resize Gambar</h2>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ url('/upload-gambar') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo" accept="image/*" required>
        <button type="submit">Upload Gambar</button>
    </form>
</body>
</html>
