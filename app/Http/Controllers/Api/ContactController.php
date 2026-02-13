<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactMessage;

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
        Mail::to('info@miurahospitality.com')
            ->send(new ContactMessage(
                $request->name,
                $request->email,
                $request->message
            ));

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
