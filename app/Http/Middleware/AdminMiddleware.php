<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        if (Auth::guard('web')->check()) {
            abort(403, 'Acceso denegado. Rol de administrador requerido.');
        }

        return redirect()->route('login')->with('flash_error', 'Inicia sesión como administrador.');
    }
}
