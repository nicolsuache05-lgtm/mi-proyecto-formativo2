<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function dashboard()
    {
        $clienteId = Auth::guard('web')->id();
        $reservas = Reserva::where('id_cliente', $clienteId)
            ->with('servicio')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();
        $servicios = Servicio::all();

        return view('dashboard.cliente', compact('reservas', 'servicios'));
    }

    public function agendarCita(Request $request)
    {
        if ($request->isMethod('post')) {
            $fecha = $request->input('fecha', '');
            $hora = $request->input('hora', '');
            $id_servicio = (int)$request->input('id_servicio', 0);

            if ($fecha < date('Y-m-d')) {
                return redirect()->back()->with('flash_error', 'No puedes agendar fechas pasadas.')->withInput();
            }

            $conflicto = Reserva::where('fecha', $fecha)
                ->where('hora', $hora)
                ->where('estado', '!=', 'cancelada')
                ->exists();

            if ($conflicto) {
                return redirect()->back()->with('flash_error', 'Ese horario ya está reservado.')->withInput();
            }

            $ok = Reserva::create([
                'fecha'        => $fecha,
                'hora'         => $hora,
                'id_cliente'   => Auth::guard('web')->id(),
                'id_servicio'  => $id_servicio,
                'id_empleados' => null,
                'estado'       => 'pendiente',
            ]);

            if ($ok) {
                return redirect()->route('cliente.misReservas')->with('flash_ok', 'Reserva creada exitosamente.');
            } else {
                return redirect()->back()->with('flash_error', 'Error al crear la reserva.')->withInput();
            }
        }

        $servicios = Servicio::all();
        return view('usuarios.agendar', compact('servicios'));
    }

    public function misReservas()
    {
        $clienteId = Auth::guard('web')->id();
        $reservas = Reserva::where('id_cliente', $clienteId)
            ->with('servicio')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('usuarios.mis-reservas', compact('reservas'));
    }

    public function cancelarReserva($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->id_cliente != Auth::guard('web')->id()) {
            abort(403, 'No autorizado.');
        }

        $reserva->update(['estado' => 'cancelada']);
        return redirect()->route('cliente.misReservas')->with('flash_ok', 'Reserva cancelada correctamente.');
    }

    public function catalogo()
    {
        $servicios = Servicio::all();
        $grupos = [];
        foreach ($servicios as $s) {
            $grupos[$s->categoria ?? 'Manicure'][] = $s;
        }

        return view('dashboard.catalogo', compact('grupos', 'servicios'));
    }
}
