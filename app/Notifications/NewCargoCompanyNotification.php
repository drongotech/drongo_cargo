<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class NewCargoCompanyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $CargoCompany;
    public function __construct($company)
    {
        $this->CargoCompany = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Welcome to Drongo Cargo')
            ->greeting('Hello ' . $this->CargoCompany->company_name)
            ->line('Your new account company has been created for Drongo Cargo Tracking System')
            ->line('You can download the Drongo Cargo Tracking System from playstore and apple store
             to tracker cargo shippments')
            ->line('Your login credential are your email address and the pincode given below.')
            ->line('Your secret pincode is ' . Crypt::decrypt($this->CargoCompany->company_pincode))
            ->line('')
            ->line('Thank you for being part of Drongo Technology');
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
            //
        ];
    }
}
