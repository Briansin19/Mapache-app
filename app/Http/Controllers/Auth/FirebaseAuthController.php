<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'uid' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
            'token' => 'required|string'
        ]);

        // Check if the user already exists
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            // Create a new user if they don't exist
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt(Str::random(16)), // Generate a random password
                'firebase_uid' => $validated['uid']
            ]);

            // Asignar el permiso para ver la ubicación de los maestros
            $user->givePermissionTo('ver-ubicacion-maestros');

            // Asignar el rol de Alumno
            $user->assignRole('Alumno');
        } else {
            // Update the firebase_uid if it doesn't match
            if ($user->firebase_uid !== $validated['uid']) {
                $user->firebase_uid = $validated['uid'];
                $user->save();
            }

            // Asegurarse de que el usuario tenga el permiso
            if (!$user->hasPermissionTo('ver-ubicacion-maestros')) {
                $user->givePermissionTo('ver-ubicacion-maestros');
            }

            // Asegurarse de que el usuario tenga el rol de Alumno
            if (!$user->hasRole('Alumno')) {
                $user->assignRole('Alumno');
            }
        }

        // Log the user in
        Auth::login($user);

        return response()->json(['success' => true]);
    }
}