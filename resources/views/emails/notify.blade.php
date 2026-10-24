<x-mail::message>
# Halo, {{ $user->name }}!

Ini adalah email pemberitahuan yang dibuat menggunakan template Markdown Laravel.

Terima kasih telah menggunakan aplikasi kami.

<x-mail::button :url="'http://127.0.0.1:8000'">
Buka Aplikasi
</x-mail::button>

Salam,

{{ config('app.name') }}
</x-mail::message>
