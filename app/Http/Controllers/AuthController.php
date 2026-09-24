<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('web')->check()) {
            return redirect()->route('cliente.dashboard');
        }

        return view('usuarios.login');
    }

    public function procesarLogin(Request $request)
    {
        $usuario = trim($request->input('correo', ''));
        $password = trim($request->input('password', ''));

        if ($usuario === '' || $password === '') {
            return redirect()->back()->with('flash_error', 'Completa todos los campos.');
        }

        // 1. Intentar Autenticar como Administrador
        $admin = Administrador::where('usuario', $usuario)->orWhere('correo', $usuario)->first();
        if ($admin) {
            $passBD = $admin->contrasena ?? $admin->contraseña ?? '';
            if (Hash::check($password, $passBD) || $password === $passBD) {
                Auth::guard('admin')->login($admin);
                return redirect()->route('admin.dashboard');
            }
        }

        // 2. Intentar Autenticar como Cliente
        $cliente = Cliente::where('correo', $usuario)->first();
        if ($cliente) {
            if (isset($cliente->activo) && !$cliente->activo) {
                return redirect()->back()->with('flash_error', 'Tu cuenta está desactivada.');
            }

            if (Auth::guard('web')->attempt(['correo' => $usuario, 'password' => $password])) {
                return redirect()->route('cliente.dashboard');
            }
        }

        return redirect()->back()->with('flash_error', 'Usuario o contraseña incorrectos.');
    }

    public function mostrarRegistro()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('web')->check()) {
            return redirect()->route('cliente.dashboard');
        }

        return view('usuarios.registro');
    }

    public function procesarRegistro(Request $request)
    {
        $nombreInput = trim($request->input('nombre', ''));
        $apellidoInput = trim($request->input('apellido', ''));
        $nombre = trim($nombreInput . ' ' . $apellidoInput);
        $telefono = trim($request->input('telefono', ''));
        $correo = trim($request->input('correo', ''));
        $password = $request->input('password');
        $confirmar = $request->input('confirmar');

        if ($nombreInput === '' || $correo === '' || $password === '') {
            return redirect()->back()->with('flash_error', 'Nombre, correo y contraseña son obligatorios.');
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('flash_error', 'El correo no tiene un formato válido.');
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('flash_error', 'La contraseña debe tener al menos 8 caracteres.');
        }

        if ($password !== $confirmar) {
            return redirect()->back()->with('flash_error', 'Las contraseñas no coinciden.');
        }

        if (Cliente::where('correo', $correo)->exists()) {
            return redirect()->back()->with('flash_error', 'Ese correo ya está registrado.');
        }

        $ok = Cliente::create([
            'nombre'   => $nombre,
            'telefono' => $telefono,
            'correo'   => $correo,
            'password' => Hash::make($password),
            'activo'   => 1
        ]);

        if ($ok) {
            return redirect()->route('login')->with('flash_ok', 'Registro exitoso. Ya puedes iniciar sesión.');
        } else {
            return redirect()->back()->with('flash_error', 'Error al crear la cuenta.');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
