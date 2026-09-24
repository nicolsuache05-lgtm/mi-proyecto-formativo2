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
            ->with(['servicio', 'detalles.servicio', 'pago'])
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
            $id_servicios = $request->input('id_servicios', []);

            if (empty($id_servicios)) {
                return redirect()->back()->with('flash_error', 'Debes seleccionar al menos un servicio.')->withInput();
            }

            if ($fecha < date('Y-m-d')) {
                return redirect()->back()->with('flash_error', 'No puedes agendar fechas pasadas.')->withInput();
            }

            $horaNormalizada = substr(trim($hora), 0, 5);

            $conflicto = Reserva::where('fecha', $fecha)
                ->where(function ($q) use ($horaNormalizada) {
                    $q->where('hora', $horaNormalizada)
                      ->orWhere('hora', 'like', $horaNormalizada . '%');
                })
                ->where('estado', '!=', 'cancelada')
                ->exists();

            if ($conflicto) {
                return redirect()->back()
                    ->with('flash_error', "⚠️ La hora {$horaNormalizada} ya se encuentra ocupada para la fecha {$fecha}. Por favor, selecciona otro horario.")
                    ->withInput();
            }

            $primary_id_servicio = (int)$id_servicios[0];

            $ok = Reserva::create([
                'fecha'        => $fecha,
                'hora'         => $horaNormalizada,
                'id_cliente'   => Auth::guard('web')->id(),
                'id_servicio'  => $primary_id_servicio,
                'id_empleados' => null,
                'estado'       => 'pendiente',
            ]);

            if ($ok) {
                foreach ($id_servicios as $id_s) {
                    $servicio = Servicio::find($id_s);
                    if ($servicio) {
                        \App\Models\DetalleServicio::create([
                            'id_reserva'      => $ok->id_reserva,
                            'id_servicio'     => (int)$id_s,
                            'cantidad'        => '1',
                            'precio_unitario' => $servicio->precio,
                            'subtotal'        => $servicio->precio,
                        ]);
                    }
                }

                return redirect()->route('cliente.misReservas')->with('flash_ok', 'Reserva creada exitosamente con los servicios seleccionados.');
            } else {
                return redirect()->back()->with('flash_error', 'Error al crear la reserva.')->withInput();
            }
        }

        $servicios = Servicio::all();
        return view('usuarios.agendar', compact('servicios'));
    }

    public function horasOcupadas(Request $request)
    {
        $fecha = $request->query('fecha', '');
        if (!$fecha) {
            return response()->json(['ocupadas' => []]);
        }

        $horas = Reserva::where('fecha', $fecha)
            ->where('estado', '!=', 'cancelada')
            ->pluck('hora')
            ->map(function ($h) {
                return substr(trim($h), 0, 5);
            })
            ->unique()
            ->values();

        return response()->json(['ocupadas' => $horas]);
    }

    public function misReservas()
    {
        $clienteId = Auth::guard('web')->id();
        $reservas = Reserva::where('id_cliente', $clienteId)
            ->with(['servicio', 'detalles.servicio'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('usuarios.mis-reservas', compact('reservas'));
    }

    public function pago()
    {
        $clienteId = Auth::guard('web')->id();
        $reservas = Reserva::where('id_cliente', $clienteId)
            ->where('estado', '!=', 'cancelada')
            ->with(['servicio', 'detalles.servicio', 'pago'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('usuarios.pago', compact('reservas'));
    }

    public function registrarPago(Request $request, $id)
    {
        $metodoPago = $request->input('metodo_pago', '');

        if (!in_array($metodoPago, ['nequi', 'efectivo'], true)) {
            return redirect()->back()->with('flash_error', 'Selecciona un método de pago válido.')->withInput();
        }

        $reserva = Reserva::where('id_reserva', $id)
            ->where('id_cliente', Auth::guard('web')->id())
            ->with(['servicio', 'detalles.servicio', 'pago'])
            ->firstOrFail();

        if ($reserva->pago) {
            return redirect()->route('cliente.pago')->with('flash_error', 'Esta reserva ya tiene un pago registrado.');
        }

        $total = $reserva->detalles->isNotEmpty()
            ? $reserva->detalles->sum('subtotal')
            : ($reserva->servicio->precio ?? 0);

        $reserva->pago()->create([
            'fecha_pago'   => date('Y-m-d'),
            'metodo_pago'  => $metodoPago,
            'valor_pagado' => $total,
        ]);

        return redirect()->route('cliente.pago.factura', $id)->with('flash_ok', '¡Pago registrado correctamente! Aquí tienes tu comprobante de factura.');
    }

    public function verFactura($id)
    {
        $clienteId = Auth::guard('web')->id();
        $reserva = Reserva::where('id_reserva', $id)
            ->where('id_cliente', $clienteId)
            ->with(['cliente', 'servicio', 'detalles.servicio', 'pago'])
            ->firstOrFail();

        if (!$reserva->pago) {
            return redirect()->route('cliente.pago')->with('flash_error', 'Esta reserva aún no tiene un pago registrado.');
        }

        return view('usuarios.factura', compact('reserva'));
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
