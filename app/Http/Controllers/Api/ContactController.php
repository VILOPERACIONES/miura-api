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

    Mail::raw(
        "Nombre: {$request->name}\nCorreo: {$request->email}\n\nMensaje:\n{$request->message}",
        function ($mail) {
            $mail->to('info@miurahospitality.com')
                ->subject('Nuevo mensaje desde Miura Website');
        }
    );

    return response()->json(['success' => true]);
}
}
