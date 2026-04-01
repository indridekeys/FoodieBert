<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    protected $booking;
    protected $recommendation;

    public function __construct($booking, $recommendation = null)
    {
        $this->booking = $booking;
        $this->recommendation = $recommendation;
    }

    public function via($notifiable)
    {
        // Sends to both the 'notifications' table in DB and via Email
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $status = strtoupper($this->booking->status);
        
        $mailMessage = (new MailMessage)
            ->subject("Update on your reservation at " . $this->booking->restaurant->name)
            ->greeting("Hello " . $notifiable->name . "!")
            ->line("Your booking status has been updated.")
            ->line("Establishment: **{$this->booking->restaurant->name}**")
            ->line("Status: **{$status}**")
            ->line("Date & Time: {$this->booking->date} at {$this->booking->time}");

        // If the owner provided an alternative or a reason
        if ($this->recommendation) {
            $mailMessage->line("Note from the Manager: ")
                        ->line("_{$this->recommendation}_");
        }

        return $mailMessage
            ->action('View My Bookings', url('/customer/bookings'))
            ->line('Thank you for choosing FoodieBert for your dining experience!');
    }

    /**
     * Data stored in the 'data' column of your 'notifications' table.
     */
    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'restaurant_name' => $this->booking->restaurant->name,
            'status' => $this->booking->status,
            'message' => "Your booking at {$this->booking->restaurant->name} is now {$this->booking->status}.",
            'recommendation' => $this->recommendation,
            'icon' => $this->booking->status == 'confirmed' ? 'fa-check-circle' : 'fa-info-circle',
        ];
    }
}