@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
  @php
  $grupos = [];
  foreach ($servicios as $s) {
      $cat = $s->categoria ?? 'Otros';
      $grupos[$cat][] = $s;
  }
  $iconos = [
      'Manicure' => '💅',
      'Pedicure' => '👣',
      'Capilar'  => '💆🏽‍♀️',
      'Otros'    => '✨',
  ];
  @endphp

  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">
    📅 Agendar nueva cita
  </h1>

  <div class="card" style="max-width:100%">

    <form action="{{ route('cliente.agendar.post') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Servicio</label>

        @if (empty($grupos))
          <p style="color:#b07090;font-size:13px">
            No hay servicios disponibles aún.
          </p>
        @else
          <div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap" id="tabs">
            @foreach (array_keys($grupos) as $i => $cat)
              <button 
                type="button"
                onclick="mostrarCategoria('{{ $cat }}')"
                id="tab-{{ $cat }}"
                style="padding:8px 18px;border-radius:50px;border:2px solid #e8527a;
                       font-family:'Poppins',sans-serif;font-size:13px;font-weight:500;
                       cursor:pointer;transition:all .2s;
                       background:{{ $i === 0 ? 'linear-gradient(135deg,#e8527a,#c93060)' : 'white' }};
                       color:{{ $i === 0 ? 'white' : '#c93060' }}"
              >
                {{ ($iconos[$cat] ?? '✨') . ' ' . $cat }}
              </button>
            @endforeach
          </div>

  <style>
    .servicio-card {
      transform: translateY(0);
      box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .servicio-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(232, 82, 122, 0.12);
    }
    .servicio-img-container {
      width: 100%;
      height: 120px;
      overflow: hidden;
      background: #fce4ef;
    }
    .servicio-img-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .servicio-card:hover .servicio-img-container img {
      transform: scale(1.08);
    }
  </style>

  @foreach ($grupos as $cat => $items)
    <div 
      id="cat-{{ $cat }}" 
      class="cat-panel"
      style="display:{{ array_key_first($grupos) === $cat ? 'grid' : 'none' }};
             grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:14px"
    >
      @foreach ($items as $s)
        <label style="cursor:pointer; display: block;">
          <input 
            type="radio" 
            name="id_servicio" 
            value="{{ $s->id_servicio }}"
            style="display:none" 
            class="radio-servicio"
            onchange="seleccionarServicio(this)"
            required
          >

          <div 
            class="servicio-card" 
            id="card-{{ $s->id_servicio }}"
            style="border:2px solid #f4c0d1;border-radius:14px;overflow:hidden;
                   background:#fdf0f5;transition:all .25s;display:flex;flex-direction:column;height:100%;"
          >
            <div class="servicio-img-container">
              <img src="{{ asset($s->imagen ?? 'img/default_servicio.png') }}" 
                   alt="{{ $s->nombre_servicio }}">
            </div>
            
            <div style="padding:12px; display:flex; flex-direction:column; flex-grow:1; justify-content:space-between;">
              <div>
                <div style="font-weight:600;color:#c0375a;font-size:14px;margin-bottom:4px">
                  {{ $s->nombre_servicio }}
                </div>
                <div style="font-size:11px;color:#8a5068;margin-bottom:10px;line-height:1.4">
                  {{ $s->descripcion ?? 'Servicio profesional para consentirte.' }}
                </div>
              </div>
              <div style="font-weight:700;color:#4a2030;font-size:14px;border-top:1px dashed #fcd0e0;padding-top:8px;margin-top:auto;">
                ${{ number_format($s->precio ?? 0, 0, ',', '.') }}
              </div>
            </div>
          </div>
        </label>
      @endforeach
    </div>
  @endforeach

          <p id="msg-servicio" style="color:#a32d2d;font-size:12px;display:none;margin-top:6px">
            Selecciona un servicio para continuar.
          </p>
        @endif
      </div>

      <div class="form-row" style="margin-top:8px">
        <div class="form-group">
          <label>Fecha</label>
          <input 
            type="date" 
            name="fecha" 
            required 
            min="{{ date('Y-m-d') }}"
            value="{{ old('fecha') }}"
          >
        </div>

        <div class="form-group">
          <label>Hora</label>
          <select name="hora" required>
            <option value="">— Hora —</option>
            @php
            $horas = [
                '08:00', '08:30', '09:00', '09:30',
                '10:00', '10:30', '11:00', '11:30',
                '12:00', '12:30', '13:00', '13:30',
                '14:00', '14:30', '15:00', '15:30',
                '16:00', '16:30', '17:00', '17:30',
                '18:00', '18:30', '19:00'
            ];
            @endphp
            @foreach ($horas as $h)
              <option value="{{ $h }}" {{ old('hora') == $h ? 'selected' : '' }}>
                {{ $h }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div style="display:flex;gap:12px;margin-top:12px">
        <button 
          type="submit" 
          class="btn btn-primary" 
          onclick="return validarFormulario()"
        >
          Confirmar reserva
        </button>

        <a 
          href="{{ route('cliente.dashboard') }}" 
          class="btn btn-outline"
        >
          Cancelar
        </a>
      </div>
    </form>
  </div>

  <script>
  function mostrarCategoria(cat) {
      const idCat = 'cat-' + cat;
      const idTab = 'tab-' + cat;

      document.querySelectorAll('.cat-panel').forEach(function(panel) {
          panel.style.display = 'none';
      });

      const panel = document.getElementById(idCat);
      if (panel) {
          panel.style.display = 'grid';
      }

      document.querySelectorAll('#tabs button').forEach(function(button) {
          button.style.background = 'white';
          button.style.color = '#c93060';
      });

      const tab = document.getElementById(idTab);
      if (tab) {
          tab.style.background = 'linear-gradient(135deg,#e8527a,#c93060)';
          tab.style.color = 'white';
      }
  }

  function seleccionarServicio(radio) {
      document.querySelectorAll('.servicio-card').forEach(function(card) {
          card.style.border = '2px solid #f4c0d1';
          card.style.background = '#fdf0f5';
      });

      const card = document.getElementById('card-' + radio.value);
      if (card) {
          card.style.border = '2px solid #e8527a';
          card.style.background = '#fce4ef';
      }

      const mensaje = document.getElementById('msg-servicio');
      if (mensaje) {
          mensaje.style.display = 'none';
      }
  }

  function validarFormulario() {
      const seleccionado = document.querySelector('input[name="id_servicio"]:checked');
      const mensaje = document.getElementById('msg-servicio');

      if (!seleccionado) {
          if (mensaje) {
              mensaje.style.display = 'block';
          }
          return false;
      }
      return true;
  }
  </script>
@endsection
