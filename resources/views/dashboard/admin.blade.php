@extends('layouts.app')

@section('title', 'Panel Admin')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">
    Panel de Administración 📊
  </h1>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="label">Total clientes</div>
      <div class="value">{{ $totalClientes ?? 0 }}</div>
    </div>
    <div class="stat-card">
      <div class="label">Total reservas</div>
      <div class="value">{{ $totalReservas ?? 0 }}</div>
    </div>
    <div class="stat-card">
      <div class="label">Total pagos</div>
      <div class="value">{{ $totalPagos ?? 0 }}</div>
    </div>
    <div class="stat-card">
      <div class="label">Servicios</div>
      <div class="value">{{ $totalServicios ?? 0 }}</div>
    </div>
  </div>

  <!-- Notificaciones de Pagos Recientes -->
  <div class="card" style="margin-bottom:1.5rem">
    <h2 style="display:flex;align-items:center;gap:8px;color:#c0375a">
      <span>🔔</span> Notificaciones & Pagos Recientes
    </h2>
    @if(isset($pagosRecientes) && $pagosRecientes->isNotEmpty())
      <div style="display:grid;gap:10px;margin-top:12px">
        @foreach($pagosRecientes as $pago)
          <div style="background:#fdf6f8;border:1px solid #f6d6e1;border-radius:12px;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
            <div style="display:flex;align-items:center;gap:12px">
              <span style="background:#eaf3de;color:#3b6d11;font-size:18px;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-weight:bold">✓</span>
              <div>
                <strong style="color:#4a2030;font-size:14px;display:block">
                  Pago registrado por {{ $pago->reserva->cliente->nombre ?? 'Cliente' }}
                </strong>
                <span style="color:#8a5068;font-size:12px">
                  Servicio: <strong>{{ $pago->reserva->servicio->nombre_servicio ?? 'Servicio' }}</strong> |
                  Método: <span class="badge badge-success">{{ strtoupper($pago->metodo_pago) }}</span> |
                  Fecha: {{ $pago->fecha_pago }}
                </span>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
              <span style="font-size:16px;font-weight:700;color:#c0375a">${{ number_format($pago->valor_pagado ?? 0, 0, ',', '.') }}</span>
              <a href="{{ route('admin.pago.factura', $pago->id_reserva) }}" class="btn btn-outline" style="padding:4px 10px;font-size:12px">
                📄 Factura
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <p style="color:#b07090;margin-top:8px">No hay pagos registrados recientemente.</p>
    @endif
  </div>

  <!-- Accesos rápidos -->
  <div class="card">
    <h2>Accesos rápidos</h2>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <a href="{{ route('admin.reservas') }}" class="btn btn-primary">📅 Ver reservas</a>
      <a href="{{ route('admin.clientes') }}" class="btn btn-outline">👥 Ver clientes</a>
      <a href="{{ route('admin.servicios') }}" class="btn btn-outline">💅 Ver servicios</a>
      <a href="{{ route('admin.pagos') }}" class="btn btn-outline">💰 Ver pagos</a>
    </div>
  </div>
@endsection
