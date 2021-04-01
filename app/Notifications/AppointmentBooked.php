<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class AppointmentBooked extends Notification
{
    use Queueable;

    private $appointment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
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
        $student = $this->appointment->student->user;
        $appointmentStart = Carbon::parse($this->appointment->start);

        $profilePhoto = $student->profile_photo_path ? url('/storage/'.$student->profile_photo_path) : url('/img/profile_placeholder.jpg');

        $data = [
            'name' => $student->first_name,
            'profile_photo_url' => $profilePhoto,
            'date' => $appointmentStart->format('h:i'),
            'time' => $appointmentStart->format('Y. m. d.'),
            'url' => url('/')
        ];

        return (new MailMessage)
            ->subject(__('mail-appointment_booked.subject'))
            ->from('info@consteach.com', __('mail.from_name'))
            ->markdown('mails.teacher.appointment_booked', ['data' => $data]);
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
