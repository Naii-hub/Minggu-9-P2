<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function resize()
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->decodePath(
            public_path('images/foto.jpg')
        );

        $image->resize(300, 200);

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 85
    );

    $binary = ltrim((string) $encoded, "\r\n\t ");

    return response($binary, 200)
        ->header('Content-Type', 'image/jpeg');

    }

public function crop()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $image->crop(300, 200, 50, 50);

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 85
    );

    file_put_contents(
        storage_path('app/crop-test.jpg'),
        (string) $encoded
    );

    return response('Hasil crop berhasil disimpan di storage/app/crop-test.jpg');
}

public function watermark()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $watermark = $manager->decodePath(
        public_path('images/watermark.png')
    );

    $watermark->scale(width: 180);

    $image->insert(
        $watermark,
        10,
        10,
        \Intervention\Image\Alignment::BOTTOM_RIGHT
    );

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 85
    );

    file_put_contents(
        storage_path('app/watermark-test.jpg'),
        (string) $encoded
    );

    return response(
        'Hasil watermark berhasil disimpan di storage/app/watermark-test.jpg'
    );
}

public function rotate()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $image->rotate(45);

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 85
    );

    file_put_contents(
        storage_path('app/rotate-test.jpg'),
        (string) $encoded
    );

    return response(
        'Hasil rotasi berhasil disimpan di storage/app/rotate-test.jpg'
    );
}

public function ubahFormat()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $encoded = $image->encodeUsingFormat(
        Format::PNG
    );

    file_put_contents(
        storage_path('app/foto.png'),
        (string) $encoded
    );

    return response(
        'Gambar berhasil diubah ke PNG dan disimpan di storage/app/foto.png'
    );
}

public function tampilBrowser()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 85
    );

    return response((string) $encoded, 200)
        ->header('Content-Type', 'image/jpeg');
}

public function upload(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $file = $request->file('photo');
    $filename = time() . '.' . $file->getClientOriginalExtension();

    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath($file->getRealPath());
    $image->resize(300, 300);

    $format = strtolower($file->getClientOriginalExtension());

    $encoded = $image->encodeUsingFormat(
        $format === 'png' ? Format::PNG : Format::JPEG,
        quality: 85
    );

    file_put_contents(
        public_path('uploads/' . $filename),
        (string) $encoded
    );

    return back()->with(
        'success',
        'Image uploaded and resized successfully: ' . $filename
    );
}

public function quality()
{
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $encoded = $image->encodeUsingFormat(
        Format::JPEG,
        quality: 75
    );

    file_put_contents(
        storage_path('app/foto-quality-75.jpg'),
        (string) $encoded
    );

    return response(
        'Gambar berhasil disimpan di storage/app/foto-quality-75.jpg'
    );
}


}