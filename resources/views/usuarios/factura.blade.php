@extends('layouts.app')

@section('title', 'Ticket POS #' . sprintf('%05d', $reserva->id_reserva))

@section('content')
<!-- Librería para descarga directa de PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
  .pos-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    max-width: 420px;
    margin: 0 auto 20px auto;
  }
  
  /* Ticket POS Container (Diseño Tira Térmica de Caja) */
  .pos-ticket {
    background: #ffffff;
    max-width: 380px;
    margin: 0 auto 40px auto;
    padding: 28px 22px;
    font-family: 'Courier New', Courier, monospace, sans-serif;
    color: #222222;
    border: 1px solid #e0d0d8;
    border-radius: 4px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
  }
  
  /* Efecto bordes troquelados estilo ticket físico */
  .pos-ticket::before,
  .pos-ticket::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    height: 6px;
    background-size: 12px 6px;
  }
  .pos-ticket::before {
    top: -6px;
    background-image: linear-gradient(135deg, #ffffff 50%, transparent 50%), linear-gradient(45deg, #ffffff 50%, transparent 50%);
  }
  .pos-ticket::after {
    bottom: -6px;
    background-image: linear-gradient(315deg, #ffffff 50%, transparent 50%), linear-gradient(225deg, #ffffff 50%, transparent 50%);
  }

  .pos-header {
    text-align: center;
    margin-bottom: 14px;
  }
  .pos-brand {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: 1px;
    color: #c0375a;
    margin: 0;
  }
  .pos-sub {
    font-size: 11px;
    text-transform: uppercase;
    color: #666;
    margin-top: 2px;
  }
  .pos-info {
    font-size: 11px;
    color: #444;
    margin-top: 4px;
    line-height: 1.4;
  }

  .pos-divider {
    border-top: 1px dashed #888888;
    margin: 12px 0;
  }
  .pos-divider-double {
    border-top: 2px solid #333333;
    margin: 12px 0;
  }

  .pos-title-box {
    text-align: center;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #333;
  }

  .pos-meta-row {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    margin: 3px 0;
  }
  .pos-meta-row strong {
    font-weight: 700;
  }

  .pos-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin: 10px 0;
  }
  .pos-table th {
    text-align: left;
    border-bottom: 1px dashed #666;
    padding-bottom: 4px;
    font-weight: 700;
  }
  .pos-table th:last-child {
    text-align: right;
  }
  .pos-table td {
    padding: 6px 0;
    vertical-align: top;
  }
  .pos-table td:last-child {
    text-align: right;
    font-weight: 700;
  }

  .pos-totals {
    font-size: 12px;
    margin-top: 8px;
  }
  .pos-total-row {
    display: flex;
    justify-content: space-between;
    margin: 4px 0;
  }
  .pos-total-row.big {
    font-size: 16px;
    font-weight: 800;
    color: #c0375a;
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    padding: 6px 0;
    margin-top: 8px;
  }

  .pos-badge-pago {
    background: #eaf3de;
    border: 1px solid #689f38;
    border-radius: 4px;
    color: #2e5b09;
    text-align: center;
    padding: 8px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 12px 0;
  }

  .pos-footer {
    text-align: center;
    font-size: 10px;
    color: #666;
    margin-top: 14px;
    line-height: 1.4;
  }

  /* Estilos para impresión (Oculta panel izquierdo, topbar y escala el ticket a tamaño legible) */
  @media print {
    @page {
      margin: 12mm;
      size: portrait;
    }
    html, body {
      background: #ffffff !important;
      margin: 0 !important;
      padding: 0 !important;
      font-size: 15px !important;
    }
    .topbar, aside, .layout > aside, .flash, .pos-actions, header, footer {
      display: none !important;
      width: 0 !important;
      height: 0 !important;
      visibility: hidden !important;
    }
    .layout {
      display: block !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    main {
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }
    .pos-ticket {
      max-width: 650px !important;
      width: 100% !important;
      border: 1px dashed #444 !important;
      border-radius: 8px !important;
      box-shadow: none !important;
      margin: 0 auto !important;
      padding: 24px 28px !important;
      font-size: 14px !important;
    }
    .pos-brand {
      font-size: 24px !important;
    }
    .pos-info, .pos-meta-row, .pos-table, .pos-totals {
      font-size: 13px !important;
    }
    .pos-total-row.big {
      font-size: 20px !important;
    }
    .pos-ticket::before,
    .pos-ticket::after {
      display: none !important;
    }
  }
</style>

<div style="max-width: 780px; margin: 0 auto;">
  <div class="pos-actions">
    @auth('admin')
      <a href="{{ route('admin.pagos') }}" class="btn btn-outline">← Volver a Pagos</a>
    @else
      <a href="{{ route('cliente.pago') }}" class="btn btn-outline">← Volver a Pagos</a>
    @endauth

    <div style="display:flex;gap:8px">
      <button onclick="descargarTicketPDF()" class="btn btn-outline" style="display:inline-flex;align-items:center;gap:6px;">
        <span>📥</span> Descargar PDF
      </button>

      <button onclick="window.print()" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:6px;">
        <span>🖨️</span> Imprimir Ticket 
      </button>
    </div>
  </div>

  <div class="pos-ticket" id="pos-ticket-container">
    <!-- Header del Negocio -->
    <div class="pos-header">
      <h1 class="pos-brand">💅 ALEJA NAILS</h1>
      <div class="pos-sub">Estudio de Belleza & Manicura</div>
      <div class="pos-info">
        NIT: 900.123.456-7<br>
        TEL / NEQUI: 318 552 8395<br>
        Contacto: alejaNails@gmail.com
      </div>
    </div>

    <div class="pos-divider-double"></div>

    <!-- Título del Recibo -->
    <div class="pos-title-box">
      COMPROBANTE DE PAGO
    </div>
    <div style="text-align:center;font-size:12px;font-weight:bold;margin-top:2px;color:#c0375a">
      TICKET #POS-{{ sprintf('%05d', $reserva->id_reserva) }}
    </div>

    <div class="pos-divider"></div>

    <!-- Información del Ticket -->
    <div class="pos-meta-row">
      <span>FECHA EMISIÓN:</span>
      <strong>{{ date('d/m/Y H:i') }}</strong>
    </div>
    <div class="pos-meta-row">
      <span>CLIENTE:</span>
      <strong>{{ $reserva->cliente->nombre ?? 'Cliente Registrado' }}</strong>
    </div>
    @if(isset($reserva->cliente->telefono))
      <div class="pos-meta-row">
        <span>TELÉFONO:</span>
        <span>{{ $reserva->cliente->telefono }}</span>
      </div>
    @endif
    <div class="pos-meta-row">
      <span>FECHA CITA:</span>
      <strong>{{ $reserva->fecha }} ({{ $reserva->hora }})</strong>
    </div>

    <div class="pos-divider"></div>

    <!-- Tabla de Ítems -->
    <table class="pos-table">
      <thead>
        <tr>
          <th>CANT | DESCRIPCIÓN</th>
          <th>TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @if ($reserva->detalles && $reserva->detalles->isNotEmpty())
          @foreach ($reserva->detalles as $detalle)
            <tr>
              <td>
                1 x {{ $detalle->servicio->nombre_servicio ?? 'Servicio' }}
              </td>
              <td>${{ number_format($detalle->subtotal ?? 0, 0, ',', '.') }}</td>
            </tr>
          @endforeach
        @else
          <tr>
            <td>
              1 x {{ $reserva->servicio->nombre_servicio ?? 'Servicio de Manicura' }}
            </td>
            <td>${{ number_format($reserva->pago->valor_pagado ?? ($reserva->servicio->precio ?? 0), 0, ',', '.') }}</td>
          </tr>
        @endif
      </tbody>
    </table>

    <div class="pos-divider"></div>

    <!-- Totales -->
    <div class="pos-totals">
      <div class="pos-total-row">
        <span>SUBTOTAL:</span>
        <span>${{ number_format($reserva->pago->valor_pagado ?? 0, 0, ',', '.') }}</span>
      </div>
      <div class="pos-total-row">
        <span>IVA (0%):</span>
        <span>$0</span>
      </div>
      <div class="pos-total-row big">
        <span>TOTAL PAGADO:</span>
        <span>${{ number_format($reserva->pago->valor_pagado ?? 0, 0, ',', '.') }}</span>
      </div>
    </div>

    <!-- Badge de Estado del Pago -->
    <div class="pos-badge-pago">
      ✓ PAGADO - {{ strtoupper($reserva->pago->metodo_pago ?? 'Nequi') }}
    </div>
    <div style="text-align:center;font-size:10px;color:#444">
      Fecha pago: {{ $reserva->pago->fecha_pago ?? date('Y-m-d') }}
    </div>

    <div class="pos-divider-double"></div>

    <!-- Pie del Ticket -->
    <div class="pos-footer">
      *** ¡GRACIAS POR TU PREFERENCIA! ***<br>
      Conserva este ticket de pago para tu cita.<br>
      www.alejaNails.com
    </div>
  </div>
</div>

<script>
  function descargarTicketPDF() {
    const element = document.getElementById('pos-ticket-container');
    const opt = {
      margin:       10,
      filename:     'Comprobante_Pago_#{{ sprintf("%05d", $reserva->id_reserva) }}.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2, useCORS: true },
      jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
  }
</script>
@endsection
