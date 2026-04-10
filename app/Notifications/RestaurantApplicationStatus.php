<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestaurantApplicationStatus extends Notification
{
    use Queueable;

    protected $status;
    protected $matricule;
    protected $restaurantName;
    protected $adminMessage; 

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $restaurantName, $matricule = null, $adminMessage = null)
    {
        $this->status = $status;
        $this->restaurantName = $restaurantName;
        $this->matricule = $matricule;
        $this->adminMessage = $adminMessage; // Assign the feedback from the admin
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; 
    }

    /**
     * Get the mail representation of the notification (Gmail).
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = new MailMessage;

        if ($this->status === 'approved') {
            $mail->subject('Congratulations! ' . $this->restaurantName . ' is Approved')
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('We are pleased to inform you that your restaurant application for "' . $this->restaurantName . '" has been approved.')
                ->line('**Your Official Matricule Number:** ' . $this->matricule);
        } else {
            $mail->error()
                ->subject('Update regarding your application for ' . $this->restaurantName)
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('Thank you for your interest in joining FoodieBert.')
                ->line('After reviewing your application for "' . $this->restaurantName . '", we regret to inform you that we cannot proceed at this time.');
        }

        // Add the custom admin message if it exists
        if ($this->adminMessage) {
            $mail->line('--- Message from Administrator ---')
                 ->line($this->adminMessage);
        }

        if ($this->status === 'approved') {
            $mail->action('Login to Dashboard', url('/login'))
                 ->line('Welcome to the FoodieBert family!');
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification (Database/Dashboard).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'restaurant_name' => $this->restaurantName,
            'status' => $this->status,
            'matricule' => $this->matricule,
            'admin_feedback' => $this->adminMessage, // Store the reason in the DB too
            'message' => $this->status === 'approved' 
                ? "Your restaurant {$this->restaurantName} was approved! Feedback: {$this->adminMessage}" 
                : "Your application for {$this->restaurantName} was rejected. Reason: {$this->adminMessage}"
        ];
    }
}