<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;
    protected $type;

    public function __construct(Appointment $appointment, $type = 'reminder')
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        if ($this->type == 'confirmation') {
            return (new MailMessage)
                ->subject('Confirmation de rendez-vous - HealthSys')
                ->greeting('Bonjour ' . $notifiable->name)
                ->line('Votre rendez-vous a été confirmé.')
                ->line('📅 Date: ' . $this->appointment->date_time->format('d/m/Y'))
                ->line('🕐 Heure: ' . $this->appointment->date_time->format('H:i'))
                ->line('👨‍⚕️ Médecin: Dr. ' . $this->appointment->doctor->user->name)
                ->action('Voir le rendez-vous', url('/appointments/' . $this->appointment->id))
                ->line('Merci de votre confiance !');
        } elseif ($this->type == 'cancellation') {
            return (new MailMessage)
                ->subject('Annulation de rendez-vous - HealthSys')
                ->greeting('Bonjour ' . $notifiable->name)
                ->line('Votre rendez-vous a été annulé.')
                ->line('📅 Date: ' . $this->appointment->date_time->format('d/m/Y'))
                ->line('🕐 Heure: ' . $this->appointment->date_time->format('H:i'))
                ->line('👨‍⚕️ Médecin: Dr. ' . $this->appointment->doctor->user->name)
                ->action('Prendre un rendez-vous', url('/patient/appointments'));
        } else {
            return (new MailMessage)
                ->subject('Rappel de rendez-vous - HealthSys')
                ->greeting('Bonjour ' . $notifiable->name)
                ->line('Vous avez un rendez-vous prévu demain :')
                ->line('📅 Date: ' . $this->appointment->date_time->format('d/m/Y'))
                ->line('🕐 Heure: ' . $this->appointment->date_time->format('H:i'))
                ->line('👨‍⚕️ Médecin: Dr. ' . $this->appointment->doctor->user->name)
                ->action('Confirmer ma présence', url('/appointments/' . $this->appointment->id . '/confirm'));
        }
    }

    public function toDatabase($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'doctor_name' => $this->appointment->doctor->user->name,
            'date_time' => $this->appointment->date_time->format('d/m/Y H:i'),
            'type' => $this->type,
            'message' => $this->type == 'confirmation' ? 'Rendez-vous confirmé' : ($this->type == 'cancellation' ? 'Rendez-vous annulé' : 'Rappel de rendez-vous demain'),
        ];
    }
}