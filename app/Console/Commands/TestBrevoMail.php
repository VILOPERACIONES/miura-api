<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestBrevoMail extends Command
{
    protected $signature = 'mail:test-brevo';
    protected $description = 'Envia un correo de prueba usando Brevo';

    public function handle()
    {
        $this->info('Iniciando envio de correo de prueba...');

        try {
            Mail::raw(
                "Este es un correo de prueba para verificar la integración con Brevo SMTP Relay.\n\n"
                ."Configuración utilizada:\n"
                ."- Host: " . config('mail.mailers.smtp.host') . "\n"
                ."- From: " . config('mail.from.address') . "\n",
                function ($mail) {
                    $mail->to('info@miurahospitality.com')
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->replyTo('test-user@example.com', 'Usuario de Prueba')
                        ->subject('Prueba de Brevo SMTP Relay');
                }
            );

            $this->info('Correo enviado exitosamente a info@miurahospitality.com');
        } catch (\Exception $e) {
            $this->error('Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
