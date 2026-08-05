@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h1 style="font-size:22px;font-weight:600;color:#c0375a">📅 Mis Reservas</h1>
    <a href="{{ route('cliente.agendar') }}" class="btn btn-primary">+ Nueva reserva</a>
  </div>

  <div class="card">
    @if ($reservas->isEmpty())
      <p style="color:#b07090;text-align:center;padding:2rem">
        No tienes reservas aún. <a href="{{ route('cliente.agendar') }}" style="color:#c0375a">¡Agenda tu primera cita!</a>
      </p>
    @else
      <div class="tabla-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Servicio</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Estado</th>
              <th>Precio</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservas as $r)
            <tr>
              <td>{{ $r->id_reserva }}</td>
              <td>
                @if ($r->detalles && $r->detalles->isNotEmpty())
                  <ul style="margin:0; padding-left:15px; font-size:13px; color:#c0375a; font-weight:500;">
                    @foreach ($r->detalles as $det)
                      @if ($det->servicio)
                        <li>{{ $det->servicio->nombre_servicio }}</li>
                      @endif
                    @endforeach
                  </ul>
                @else
                  {{ $r->servicio->nombre_servicio ?? 'Servicio no encontrado' }}
                @endif
              </td>
              <td>{{ $r->fecha }}</td>
              <td>{{ $r->hora }}</td>
              <td><span class="badge badge-{{ $r->estado }}">{{ ucfirst($r->estado) }}</span></td>
              <td>
                @if ($r->detalles && $r->detalles->isNotEmpty())
                  ${{ number_format($r->detalles->sum('subtotal'), 0, ',', '.') }}
                @else
                  ${{ number_format($r->servicio->precio ?? 0, 0, ',', '.') }}
                @endif
              </td>
              <td>
                @if ($r->estado === 'pendiente')
                  <a href="{{ route('cliente.cancelarReserva', $r->id_reserva) }}"
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('¿Segura que deseas cancelar esta reserva?')">
                    Cancelar
                  </a>
                @else
                  <span style="color:#b07090;font-size:12px">—</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
