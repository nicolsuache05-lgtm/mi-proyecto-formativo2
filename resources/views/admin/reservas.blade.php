@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">📅 Reservas</h1>

  <div class="card">
    @if ($reservas->isEmpty())
      <p style="color:#b07090">No hay reservas registradas.</p>
    @else
      <div class="tabla-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Servicio</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Estado</th>
              <th>Cambiar estado</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservas as $r)
            <tr>
              <td>{{ $r->id_reserva }}</td>
              <td>{{ $r->cliente->nombre ?? 'Desconocido' }}</td>
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
                <form action="{{ route('admin.reservas.actualizar') }}" method="POST" style="display:flex;gap:6px">
                  @csrf
                  <input type="hidden" name="id" value="{{ $r->id_reserva }}">
                  <select name="estado" style="padding:5px 8px;border-radius:8px;border:1px solid #f4c0d1;font-size:12px; width: auto; margin: 0;">
                    @foreach (['pendiente','confirmada','en_curso','completada','cancelada'] as $e)
                      <option value="{{ $e }}" {{ $r->estado === $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
