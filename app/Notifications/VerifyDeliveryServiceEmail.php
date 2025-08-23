<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DeliveryService;

class VerifyDeliveryServiceEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $verificationUrl = route('delivery-service.verify-email', [
        'token' => $this->deliveryService->email_verification_token
    ]);

    \Log::info('URL de vérification générée: ' . $verificationUrl);

    return (new MailMessage)
        ->subject('Vérification de votre email - Service de Livraison')
        ->greeting('Bonjour ' . $this->deliveryService->nom . ' !')
        ->line('Votre compte service de livraison a été créé avec succès.')
        ->line('Veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous.')
        ->action('Vérifier mon email', $verificationUrl)
        ->line('Si vous n\'avez pas créé de compte, veuillez ignorer cet email.');
}
}