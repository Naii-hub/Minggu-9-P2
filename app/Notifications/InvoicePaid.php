<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Notifikasi Pembayaran')
            ->greeting('Halo!')
            ->line('Invoice telah dibayar.')
            ->action('Lihat Invoice', url('/invoices'))
            ->line('Terima kasih!');
    }
}
