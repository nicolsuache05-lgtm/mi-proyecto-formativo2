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
