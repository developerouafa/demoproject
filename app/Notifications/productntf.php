<?php

namespace App\Notifications;

use App\Models\product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class productntf extends Notification
{
    use Queueable;
    private $idd;
    private $user_create;
    private $title;
    private $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(product $idd, $user_create, $title, $body)
    {
        $this->idd = $idd;
        $this->user_create = $user_create;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'idd' => $this->idd->id,
            'user_create' => $this->user_create,
            'title' => $this->title->title,
            'body' => $this->body->body
        ];
    }
}
