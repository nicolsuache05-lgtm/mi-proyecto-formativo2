@extends('layouts.app')

@section('title', 'Módulo Técnico de Pagos')

@section('content')
  <style>
    .pago-tech-header {
      background: linear-gradient(135deg, #2b0b18 0%, #4a1228 50%, #6b1d3d 100%);
      border: 1px solid #7d264a;
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(74, 18, 40, 0.2);
      color: #ffffff;
      padding: 24px 28px;
      margin-bottom: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }
    .pago-tech-eyebrow {
      color: #ff9ebb;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 4px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .pago-tech-eyebrow::before {
      content: '';
      display: inline-block;
      width: 8px;
      height: 8px;
      background: #00e676;
      border-radius: 50%;
      box-shadow: 0 0 8px #00e676;
    }
    .pago-tech-title {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 4px;
      letter-spacing: -0.5px;
    }
    .pago-tech-subtitle {
      color: #fce4ef;
      font-size: 12px;
      opacity: 0.9;
    }
    .pago-status-pill {
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.25);
      border-radius: 30px;
      padding: 8px 16px;
      font-size: 12px;
      font-weight: 600;
      color: #ffffff;
      backdrop-filter: blur(4px);
    }

    /* Technical Metrics Bar */
    .pago-metrics {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }
    .metric-card {
      background: #ffffff;
      border: 1px solid #f2d4e0;
      border-radius: 14px;
      padding: 16px 20px;
      box-shadow: 0 4px 15px rgba(200, 60, 100, 0.05);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .metric-info label {
      color: #995070;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      display: block;
      margin-bottom: 2px;
    }
    .metric-info .val {
      font-size: 22px;
      font-weight: 800;
      color: #4a1228;
    }
    .metric-icon-box {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #fdf0f5;
      color: #c0375a;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      border: 1px solid #f8cee0;
    }

    /* Technical Nequi Gateway Banner */
    .nequi-gateway {
      background: linear-gradient(110deg, #1b0726 0%, #3b1248 100%);
      border: 1px solid #5a1e6e;
      border-radius: 16px;
      padding: 18px 24px;
      color: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 24px;
      box-shadow: 0 8px 20px rgba(27, 7, 38, 0.15);
    }
    .nequi-gw-title {
      font-size: 15px;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 2px;
    }
    .nequi-gw-sub {
      font-size: 11px;
      color: #d8b4e2;
    }
    .nequi-num-box {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      padding: 8px 14px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .nequi-num-box strong {
      font-size: 17px;
      font-family: monospace;
      letter-spacing: 1px;
      color: #ff9ebb;
    }
    .btn-copy {
      background: #ffffff;
      color: #48125a;
      border: none;
      border-radius: 6px;
      padding: 6px 12px;
      font-size: 11px;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-copy:hover {
      background: #fce4ef;
    }

    /* Cards de Transacciones de Citas */
    .trx-card {
      background: #ffffff;
      border: 1px solid #f2d4e0;
      border-radius: 18px;
      box-shadow: 0 6px 20px rgba(200, 60, 100, 0.06);
      margin-bottom: 20px;
      overflow: hidden;
    }
    .trx-card-header {
      background: #fdf6f8;
      border-bottom: 1px solid #f6d6e1;
      padding: 14px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .trx-code {
      font-family: monospace;
      font-size: 12px;
      font-weight: 700;
      color: #8a3055;
      background: #fce8f0;
      padding: 4px 10px;
      border-radius: 6px;
      border: 1px solid #f4c0d1;
    }
    .trx-status-badge {
      font-size: 11px;
      font-weight: 700;
      padding: 5px 12px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .trx-status-badge.pendiente {
      background: #fff8e1;
      color: #b78103;
      border: 1px solid #ffe082;
    }
    .trx-status-badge.liquidado {
      background: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #a5d6a7;
    }

    .trx-body {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 24px;
      padding: 24px;
    }
    .trx-details {
      border-right: 1px solid #f6d6e1;
      padding-right: 24px;
    }
    .trx-service-title {
      font-size: 18px;
      font-weight: 700;
      color: #4a1228;
      margin-bottom: 12px;
    }
    .trx-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
      margin-bottom: 16px;
    }
    .trx-table td {
      padding: 6px 0;
      border-bottom: 1px dashed #f6d6e1;
      color: #666666;
    }
    .trx-table td:last-child {
      text-align: right;
      font-weight: 600;
      color: #222222;
    }
    .trx-total-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fdf0f5;
      padding: 12px 16px;
      border-radius: 10px;
      border: 1px solid #f8cee0;
    }
    .trx-total-box label {
      font-size: 12px;
      font-weight: 700;
      color: #995070;
      text-transform: uppercase;
    }
    .trx-total-box .price {
      font-size: 20px;
      font-weight: 800;
      color: #c0375a;
    }

    .trx-action-side {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .method-radio-group {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 16px;
    }
    .method-card {
      position: relative;
      cursor: pointer;
    }
    .method-card input {
      position: absolute;
      opacity: 0;
    }
    .method-box {
      border: 1.5px solid #f4c0d1;
      background: #fdf8fa;
      border-radius: 12px;
      padding: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.2s;
    }
    .method-card input:checked + .method-box {
      border-color: #c0375a;
      background: #fce8f0;
      box-shadow: 0 0 0 3px rgba(192, 55, 90, 0.12);
    }
    .method-icon {
      font-size: 20px;
      background: #ffffff;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .method-text strong {
      display: block;
      font-size: 12px;
      color: #4a1228;
    }
    .method-text small {
      font-size: 10px;
      color: #995070;
    }

    .paid-confirm-box {
      background: #f1f8e9;
      border: 1px solid #c8e6c9;
      border-radius: 12px;
      padding: 16px;
      text-align: center;
      margin-bottom: 12px;
    }
    .paid-confirm-box .icon {
      font-size: 28px;
      color: #2e7d32;
      margin-bottom: 4px;
    }
    .paid-confirm-box strong {
      display: block;
      font-size: 14px;
      color: #1b5e20;
    }
    .paid-confirm-box small {
      font-size: 11px;
      color: #388e3c;
    }

    @media (max-width: 768px) {
      .pago-metrics { grid-template-columns: 1fr; }
      .trx-body { grid-template-columns: 1fr; }
      .trx-details { border-right: none; border-bottom: 1px solid #f6d6e1; padding-right: 0; padding-bottom: 20px; }
    }
  </style>

  <!-- Technical Header -->
  <div class="pago-tech-header">
    <div>
      <div class="pago-tech-eyebrow">PASARELA DE LIQUIDACIÓN TÉCNICA FINANCIERA</div>
      <h1 class="pago-tech-title">Módulo de Pagos & Comprobantes 💳</h1>
      <p class="pago-tech-subtitle">Gestión de transacciones, liquidación de reservas y emisión de comprobantes autorizados.</p>
    </div>
    <div class="pago-status-pill">
      ⚡ Sistema de Pagos Activo
    </div>
  </div>

  @php
    $pendientes = $reservas->whereNull('pago')->count();
    $pagadas = $reservas->whereNotNull('pago')->count();
    $totalPendiente = $reservas->whereNull('pago')->sum(function ($reserva) {
        return $reserva->detalles->isNotEmpty()
            ? $reserva->detalles->sum('subtotal')
            : ($reserva->servicio->precio ?? 0);
    });
  @endphp

  <!-- Financial Metrics Bar -->
  <div class="pago-metrics">
    <div class="metric-card">
      <div class="metric-info">
        <label>Por Liquidar</label>
        <div class="val">{{ $pendientes }}</div>
      </div>
      <div class="metric-icon-box">⏳</div>
    </div>
    <div class="metric-card">
      <div class="metric-info">
        <label>Liquidadas (Pagadas)</label>
        <div class="val">{{ $pagadas }}</div>
      </div>
      <div class="metric-icon-box" style="background:#e8f5e9;color:#2e7d32;border-color:#c8e6c9">✓</div>
    </div>
    <div class="metric-card">
      <div class="metric-info">
        <label>Balance Pendiente</label>
        <div class="val">${{ number_format($totalPendiente, 0, ',', '.') }}</div>
      </div>
      <div class="metric-icon-box">💵</div>
    </div>
  </div>

  <!-- Gateway Nequi Info -->
  <div class="nequi-gateway">
    <div>
      <div style="font-size:10px;text-transform:uppercase;letter-spacing:1.2px;color:#ff9ebb;font-weight:700">Pasarela Digital Autorizada</div>
      <div class="nequi-gw-title">Transferencia en Línea vía Nequi</div>
      <div class="nequi-gw-sub">Realiza tu pago digital a la cuenta oficial e indica el número de tu reserva.</div>
    </div>
    <div class="nequi-num-box">
      <strong>318 552 8395</strong>
      <button class="btn-copy" onclick="copiarNequi(this)">Copiar</button>
    </div>
  </div>

  <!-- Lista de Reservas / Transacciones -->
  @if ($reservas->isEmpty())
    <div style="background:#fff;border:1px dashed #f4c0d1;border-radius:18px;padding:40px;text-align:center;color:#8a5068">
      <div style="font-size:36px;margin-bottom:10px">✨</div>
      <h3 style="color:#c0375a;font-size:18px;margin-bottom:6px">No hay transacciones registradas</h3>
      <p style="font-size:13px;margin-bottom:16px">Cuando agendes una cita, aparecerá su ficha técnica de liquidación en este módulo.</p>
      <a href="{{ route('cliente.agendar') }}" class="btn btn-primary">Agendar nueva cita</a>
    </div>
  @else
    <div style="display:grid;gap:20px">
      @foreach ($reservas as $reserva)
        @php
          $total = $reserva->detalles->isNotEmpty()
              ? $reserva->detalles->sum('subtotal')
              : ($reserva->servicio->precio ?? 0);
        @endphp
        <div class="trx-card">
          <div class="trx-card-header">
            <div>
              <span class="trx-code">TRX-{{ sprintf('%05d', $reserva->id_reserva) }}</span>
              <span style="font-size:12px;color:#8a5068;margin-left:8px">Reg: {{ $reserva->fecha }}</span>
            </div>
            <span class="trx-status-badge {{ $reserva->pago ? 'liquidado' : 'pendiente' }}">
              {{ $reserva->pago ? '✓ Liquidado' : '● Pendiente' }}
            </span>
          </div>

          <div class="trx-body">
            <div class="trx-details">
              <div class="trx-service-title">
                {{ $reserva->servicio->nombre_servicio ?? 'Servicio Seleccionado' }}
              </div>
              <table class="trx-table">
                <tr>
                  <td>Fecha de Atención:</td>
                  <td>{{ $reserva->fecha }}</td>
                </tr>
                <tr>
                  <td>Hora Programada:</td>
                  <td>{{ $reserva->hora }}</td>
                </tr>
                <tr>
                  <td>Estado de la Cita:</td>
                  <td><span class="badge badge-confirmada">{{ ucfirst($reserva->estado) }}</span></td>
                </tr>
                <tr>
                  <td>Tarifa Base Servicio:</td>
                  <td>${{ number_format($total, 0, ',', '.') }}</td>
                </tr>
              </table>

              <div class="trx-total-box">
                <label>Monto Total Cita</label>
                <div class="price">${{ number_format($total, 0, ',', '.') }}</div>
              </div>
            </div>

            <div class="trx-action-side">
              @if ($reserva->pago)
                <div class="paid-confirm-box">
                  <div class="icon">✓</div>
                  <strong>Pago Aprobado y Registrado</strong>
                  <small>Vía {{ strtoupper($reserva->pago->metodo_pago) }} el {{ $reserva->pago->fecha_pago }}</small>
                </div>
                <a href="{{ route('cliente.pago.factura', $reserva->id_reserva) }}" class="btn btn-outline" style="width:100%;text-align:center;display:block">
                  📄 Ver / Imprimir Comprobante Técnico
                </a>
              @else
                <h4 style="font-size:13px;color:#4a1228;margin-bottom:10px;font-weight:700">Seleccionar Método de Liquidación:</h4>
                <form action="{{ route('cliente.pago.registrar', $reserva->id_reserva) }}" method="POST">
                  @csrf
                  <div class="method-radio-group">
                    <label class="method-card">
                      <input type="radio" name="metodo_pago" value="nequi" required {{ old('metodo_pago') === 'nequi' ? 'checked' : '' }}>
                      <div class="method-box">
                        <div class="method-icon">📱</div>
                        <div class="method-text">
                          <strong>Nequi</strong>
                          <small>Transf. Digital</small>
                        </div>
                      </div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="metodo_pago" value="efectivo" required {{ old('metodo_pago') === 'efectivo' ? 'checked' : '' }}>
                      <div class="method-box">
                        <div class="method-icon">💵</div>
                        <div class="method-text">
                          <strong>Efectivo</strong>
                          <small>Pago en Local</small>
                        </div>
                      </div>
                    </label>
                  </div>

                  <button type="submit" class="btn btn-primary" style="width:100%">
                    Confirmar Pago & Generar Comprobante
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <script>
    function copiarNequi(btn) {
      navigator.clipboard.writeText('3185528395').then(function() {
        const orig = btn.innerText;
        btn.innerText = '¡Copiado!';
        btn.style.background = '#00e676';
        btn.style.color = '#000';
        setTimeout(() => {
          btn.innerText = orig;
          btn.style.background = '#ffffff';
          btn.style.color = '#48125a';
        }, 1600);
      });
    }
  </script>
@endsection
