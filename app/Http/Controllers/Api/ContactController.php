<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            Mail::raw(
                "Nombre: {$request->name}\n"
                ."Correo: {$request->email}\n\n"
                ."Mensaje:\n{$request->message}",
                function ($mail) use ($request) {
                    $mail->to('info@miurahospitality.com')
                        ->from(
                            config('mail.from.address'),
                            config('mail.from.name')
                        )
                        ->replyTo($request->email, $request->name)
                        ->subject('Nuevo mensaje desde Miura Website');
                }
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error al enviar correo via Brevo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el correo. Por favor intente más tarde.'
            ], 500);
        }
    }
}
