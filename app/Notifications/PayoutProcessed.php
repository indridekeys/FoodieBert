<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutProcessed extends Notification
{
    use Queueable;

    protected $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        // You can add 'database' here too if you want an on-screen alert
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payout Confirmed - FoodieBert')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your withdrawal request for ' . number_format(abs($this->transaction->amount)) . ' FCFA has been processed.')
            ->line('The funds have been sent to your ' . $this->transaction->meta['method'] . ' account.')
            ->action('View Earnings Vault', route('agent.earnings'))
            ->line('Thank you for being part of the FoodieBert logistics team!');
    }
}
