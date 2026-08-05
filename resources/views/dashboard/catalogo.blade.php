@extends('layouts.app')

@section('title', 'Catálogo de Servicios')

@section('content')
  <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">
    💅 Catálogo de Servicios
  </h1>

  <style>
    .catalogo-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(232, 82, 122, 0.12);
    }
    .catalogo-card:hover .catalogo-img {
      transform: scale(1.06);
    }
  </style>

  @if (empty($grupos))
    <div class="card">
      <p style="color:#b07090">No hay servicios disponibles en este momento.</p>
    </div>
  @else
    @foreach ($grupos as $categoria => $servicios)
      <div class="card">
        <h2 style="border-bottom: 2px solid #fce4ef; padding-bottom: 8px;">✨ Categoría: {{ $categoria }}</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:16px; margin-top: 15px;">
          @foreach ($servicios as $s)
            <div style="background:#fdf0f5;border-radius:14px;border: 1px solid #fce4ef; overflow:hidden; display:flex; flex-direction:column; height:100%; transition: transform 0.2s, box-shadow 0.2s;" class="catalogo-card">
              <div style="width:100%; height:140px; overflow:hidden; background:#fce4ef;">
                <img src="{{ asset($s->imagen ?? 'img/default_servicio.png') }}" 
                     alt="{{ $s->nombre_servicio }}" 
                     style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s;"
                     class="catalogo-img">
              </div>
              <div style="padding:16px; display:flex; flex-direction:column; flex-grow:1; justify-content:space-between;">
                <div>
                  <div style="font-weight:600;color:#c0375a;margin-bottom:6px; font-size: 15px;">{{ $s->nombre_servicio }}</div>
                  <p style="font-size:12px;color:#8a5068;margin-bottom:12px; line-height:1.4; min-height: 36px;">{{ $s->descripcion ?? 'Servicio profesional para consentirte.' }}</p>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #fcd0e0; padding-top: 10px; margin-top:auto;">
                  <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #b07090; font-weight: 500;">{{ $s->categoria }}</span>
                  <span style="font-weight:600;color:#4a2030; font-size: 14px;">${{ number_format($s->precio ?? 0, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  @endif
@endsection
