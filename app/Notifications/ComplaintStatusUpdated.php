<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Tambahkan "implements ShouldQueue" agar pengiriman email 
// dilakukan di background dan web tidak "loading" kelamaan.
class ComplaintStatusUpdated extends Notification
{
    use Queueable;

    protected $complaint;
    protected $oldStatus;
    protected $newStatus;
    protected $logMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($complaint, $oldStatus, $newStatus, $logMessage = null)
    {
        $this->complaint = $complaint;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->logMessage = $logMessage;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Menandakan bahwa notifikasi ini dikirim via Email
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // URL khusus untuk tombol di dalam email menuju halaman detail
        $url = url('/complaints/' . $this->complaint->id);

        $mail = (new MailMessage)
            ->subject('Pembaruan Status: ' . $this->complaint->title)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Status pengaduan Anda berjudul "' . $this->complaint->title . '" baru saja diperbarui.')
            ->line('Status Sebelumnya: ' . strtoupper($this->oldStatus))
            ->line('Status Saat Ini: ' . strtoupper($this->newStatus));

        // Jika petugas/admin meninggalkan pesan saat mengubah status
        if ($this->logMessage) {
            $mail->line('Catatan dari Petugas:')
                 ->line('"' . $this->logMessage . '"');
        }

        return $mail->action('Lihat Detail Pengaduan', $url)
                    ->line('Terima kasih telah menggunakan sistem pengaduan kami!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}