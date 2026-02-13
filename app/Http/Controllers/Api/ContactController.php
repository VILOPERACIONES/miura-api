<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Usamos config() en lugar de env() porque env() devuelve null si la configuración está en caché.
        $recipient = config('mail.from.address', 'info@miurahospitality.com');

        Mail::raw(
            "Nombre: {$request->name}\nCorreo: {$request->email}\n\nMensaje:\n{$request->message}",
            function ($mail) use ($request, $recipient) {
                $mail->to($recipient)
                    ->replyTo($request->email, $request->name)
                    ->subject('Nuevo mensaje desde Miura Website');
            }
        );

        return response()->json(['success' => true]);
    }
}
