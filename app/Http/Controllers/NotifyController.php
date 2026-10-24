<?php

namespace App\Http\Controllers;

use App\Mail\NotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotifyController extends Controller
{
    public function send()
    {
        $user = (object) [
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
        ];

        Mail::to($user->email)->send(new NotifyUser($user));

        return response()->json([
            'message' => 'Email Markdown berhasil dikirim!'
        ]);
    }
}
