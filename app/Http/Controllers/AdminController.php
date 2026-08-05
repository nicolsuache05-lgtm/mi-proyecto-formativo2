<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClientes = Cliente::count();
        $totalReservas = Reserva::count();
        $totalPagos = Pago::count();
        $totalServicios = Servicio::count();

        return view('dashboard.admin', compact('totalClientes', 'totalReservas', 'totalPagos', 'totalServicios'));
    }

    public function listarClientes()
    {
        $clientes = Cliente::orderBy('id_cliente', 'desc')->get();
        return view('admin.clientes', compact('clientes'));
    }

    public function toggleCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->activo = $cliente->activo == 1 ? 0 : 1;
        $cliente->save();

        return redirect()->route('admin.clientes')->with('flash_ok', 'Estado del cliente actualizado correctamente.');
    }

    public function listarReservas()
    {
        $reservas = Reserva::with(['cliente', 'servicio', 'empleado'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('admin.reservas', compact('reservas'));
    }

    public function actualizarReserva(Request $request)
    {
        $id = (int)$request->input('id', 0);
        $estado = $request->input('estado', '');

        $estadosValidos = [
            'pendiente',
            'confirmada',
            'en_curso',
            'completada',
            'cancelada'
        ];

        if ($id > 0 && in_array($estado, $estadosValidos, true)) {
            $reserva = Reserva::findOrFail($id);
            $reserva->update(['estado' => $estado]);
            return redirect()->route('admin.reservas')->with('flash_ok', 'Reserva actualizada correctamente.');
        }

        return redirect()->route('admin.reservas')->with('flash_error', 'Estado de reserva no válido.');
    }

    public function listarServicios()
    {
        $servicios = Servicio::orderBy('categoria', 'asc')
            ->orderBy('nombre_servicio', 'asc')
            ->get();

        return view('admin.servicios', compact('servicios'));
    }

    public function guardarServicio(Request $request)
    {
        // Validación de precio mayor o igual a cero e imagen
        $request->validate([
            'nombre_servicio' => 'required|string|max:30',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'precio.min' => 'El precio debe ser un número mayor o igual a cero.',
            'precio.numeric' => 'El precio debe ser un número.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        $imagenPath = 'img/default_servicio.png';
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/uploads'), $filename);
            $imagenPath = 'img/uploads/' . $filename;
        }

        Servicio::create([
            'nombre_servicio' => $request->input('nombre_servicio'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'categoria' => $request->input('categoria', 'Manicure'),
            'id_administrador' => Auth::guard('admin')->id(),
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('admin.servicios')->with('flash_ok', 'Servicio creado correctamente.');
    }

    public function actualizarServicio(Request $request)
    {
        $id = (int)$request->input('id_servicio', 0);

        // Validación de precio mayor o igual a cero
        $request->validate([
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'precio.min' => 'El precio debe ser un número mayor o igual a cero.',
            'precio.numeric' => 'El precio debe ser un número.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        $servicio = Servicio::findOrFail($id);
        
        $datos = [
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
        ];

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/uploads'), $filename);
            $datos['imagen'] = 'img/uploads/' . $filename;
        }

        // Si se pasa nombre_servicio, también actualizarlo
        if ($request->filled('nombre_servicio')) {
            $datos['nombre_servicio'] = $request->input('nombre_servicio');
        }
        if ($request->filled('categoria')) {
            $datos['categoria'] = $request->input('categoria');
        }

        $servicio->update($datos);

        return redirect()->route('admin.servicios')->with('flash_ok', 'Servicio actualizado correctamente.');
    }

    public function eliminarServicio(Request $request)
    {
        $id = (int)$request->input('id_servicio', 0);
        $servicio = Servicio::findOrFail($id);

        // Validar si tiene reservas asociadas
        if ($servicio->reservas()->exists()) {
            return redirect()->route('admin.servicios')->with('flash_error', 'El servicio no puede eliminarse por tener reservas vinculadas.');
        }

        $servicio->delete();

        return redirect()->route('admin.servicios')->with('flash_ok', 'Servicio eliminado correctamente.');
    }

    public function verPagos()
    {
        $pagos = Pago::with(['reserva.cliente', 'reserva.servicio'])
            ->orderBy('id_pago', 'desc')
            ->get();

        return view('admin.pagos', compact('pagos'));
    }
}
