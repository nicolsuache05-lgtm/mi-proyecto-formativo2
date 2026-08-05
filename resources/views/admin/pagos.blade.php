@extends('layouts.app')

@section('title', 'Pagos')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">💰 Pagos</h1>

  <div class="card">
    @if ($pagos->isEmpty())
      <p style="color:#b07090">No hay pagos registrados.</p>
    @else
      <div class="tabla-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Servicio</th>
              <th>Fecha pago</th>
              <th>Método</th>
              <th>Valor</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pagos as $p)
            <tr>
              <td>{{ $p->id_pago }}</td>
              <td>{{ $p->reserva->cliente->nombre ?? 'Cliente no encontrado' }}</td>
              <td>{{ $p->reserva->servicio->nombre_servicio ?? 'Servicio no encontrado' }}</td>
              <td>{{ $p->fecha_pago }}</td>
              <td>{{ $p->metodo_pago }}</td>
              <td>${{ number_format($p->valor_pagado ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
