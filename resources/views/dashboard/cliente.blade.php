@extends('layouts.app')

@section('title', 'Mi Panel')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">
    Bienvenida, {{ Auth::guard('web')->user()->nombre }} 💅
  </h1>

  <!-- Stats rápidas -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="label">Mis reservas</div>
      <div class="value">{{ $reservas->count() }}</div>
    </div>
    <div class="stat-card">
      <div class="label">Pendientes</div>
      <div class="value">{{ $reservas->where('estado', 'pendiente')->count() }}</div>
    </div>
    <div class="stat-card">
      <div class="label">Completadas</div>
      <div class="value">{{ $reservas->where('estado', 'completada')->count() }}</div>
    </div>
  </div>

  <!-- Acciones rápidas -->
  <div class="card">
    <h2>¿Qué deseas hacer?</h2>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <a href="{{ route('cliente.agendar') }}" class="btn btn-primary">📅 Agendar nueva cita</a>
      <a href="{{ route('cliente.misReservas') }}" class="btn btn-outline">📋 Ver mis reservas</a>
      <a href="{{ route('cliente.catalogo') }}" class="btn btn-outline">💅 Catálogo agrupado</a>
    </div>
  </div>

  <!-- Últimas reservas -->
  <div class="card">
    <h2>📅 Mis últimas reservas</h2>

    @if ($reservas->isEmpty())
      <p style="color:#b07090">Aún no tienes reservas. <a href="{{ route('cliente.agendar') }}" style="color:#c0375a">¡Agenda tu primera cita!</a></p>
    @else
      <div class="tabla-wrap">
        <table>
          <thead>
            <tr>
              <th>Servicio</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Estado</th>
              <th>Precio</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservas->take(5) as $r)
            <tr>
              <td>{{ $r->servicio->nombre_servicio ?? 'Servicio no encontrado' }}</td>
              <td>{{ $r->fecha }}</td>
              <td>{{ $r->hora }}</td>
              <td><span class="badge badge-{{ $r->estado }}">{{ ucfirst($r->estado) }}</span></td>
              <td>${{ number_format($r->servicio->precio ?? 0, 0, ',', '.') }}</td>
              <td>
                @if ($r->estado === 'pendiente')
                  <a href="{{ route('cliente.cancelarReserva', $r->id_reserva) }}"
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('¿Cancelar esta reserva?')">Cancelar</a>
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

  <!-- Catálogo de servicios -->
  @if (!$servicios->isEmpty())
  <div class="card">
    <h2>💅 Nuestros servicios</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px">
      @foreach ($servicios as $s)
      <div style="background:#fdf0f5;border-radius:14px;padding:16px">
        <div style="font-weight:600;color:#c0375a;margin-bottom:4px">{{ $s->nombre_servicio }}</div>
        <div style="font-size:12px;color:#8a5068;margin-bottom:8px">{{ $s->descripcion ?? '' }}</div>
        <div style="font-weight:600;color:#4a2030">${{ number_format($s->precio ?? 0, 0, ',', '.') }}</div>
      </div>
      @endforeach
    </div>
  </div>
  @endif
@endsection
