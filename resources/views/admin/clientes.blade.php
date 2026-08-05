@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">👥 Clientes</h1>

  <div class="card">
    @if ($clientes->isEmpty())
      <p style="color:#b07090">No hay clientes registrados.</p>
    @else
      <div class="tabla-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($clientes as $c)
            <tr>
              <td>{{ $c->id_cliente }}</td>
              <td>{{ $c->nombre }}</td>
              <td>{{ $c->correo }}</td>
              <td>{{ $c->telefono ?? '—' }}</td>
              <td>
                <span class="badge badge-{{ $c->activo ? 'activo' : 'inactivo' }}">
                  {{ $c->activo ? 'Activo' : 'Inactivo' }}
                </span>
              </td>
              <td>
                <form action="{{ route('admin.clientes.toggle', $c->id_cliente) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit"
                     class="btn btn-sm {{ $c->activo ? 'btn-danger' : 'btn-outline' }}"
                     onclick="return confirm('¿Cambiar estado del cliente?')">
                    {{ $c->activo ? 'Desactivar' : 'Activar' }}
                  </button>
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
