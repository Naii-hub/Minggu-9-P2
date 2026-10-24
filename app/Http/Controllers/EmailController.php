<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send()
    {
        $user = (object) [
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
        ];

        Mail::to($user->email)->queue(new WelcomeMail($user));

        return response()->json([
            'message' => 'Email berhasil diproses!',
        ]);
    }
}

