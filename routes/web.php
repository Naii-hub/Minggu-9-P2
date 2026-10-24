<?php

use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NotifyController;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/uji-gambar', function () {
    $manager = new ImageManager(new Driver());

    $image = $manager->decodePath(
        public_path('images/foto.jpg')
    );

    $encoded = $image->encodeUsingFormat(
        \Intervention\Image\Format::JPEG,
        quality: 85
    );

    return response((string) $encoded)
        ->header('Content-Type', 'image/jpeg');
});

Route::get('/resize-gambar', [ImageController::class, 'resize']);

Route::get('/crop-gambar', [ImageController::class, 'crop']);

Route::get('/watermark-gambar', [ImageController::class, 'watermark']);

Route::get('/rotate-gambar', [ImageController::class, 'rotate']);

Route::get('/ubah-format-gambar', [ImageController::class, 'ubahFormat']);

Route::get('/tampil-gambar', [ImageController::class, 'tampilBrowser']);

Route::get('/upload-gambar', function () {
    return view('upload');
});

Route::post('/upload-gambar', [ImageController::class, 'upload']);

Route::get('/quality-gambar', [ImageController::class, 'quality']);

Route::get('/kirim-email', [EmailController::class, 'send']);

Route::get('/kirim-markdown', [NotifyController::class, 'send']);

Route::get('/email/verify', function () {
    return 'Silakan periksa email untuk melakukan verifikasi.';
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return 'Email berhasil diverifikasi!';
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link verifikasi dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/register', [RegisterController::class, 'showForm']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/kirim-notifikasi', function () {
    $user = \App\Models\User::first();

    if (!$user) {
        return response()->json([
            'message' => 'Belum ada user. Daftarkan user terlebih dahulu.'
        ], 404);
    }

    Notification::send($user, new InvoicePaid());

    return response()->json([
        'message' => 'Notifikasi berhasil dikirim!',
        'email' => $user->email
    ]);
});
