<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        if (! $user->is_admin) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        // Revocar tokens anteriores (opcional pero recomendado)
        $user->tokens()->delete();

        // Crear token
        $token = $user->createToken('admin-token')->plainTextToken; //TODO: PASAR EN UN ENV EL NOMBRE DEL TOKEN

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ],
        ]);
    }

}
