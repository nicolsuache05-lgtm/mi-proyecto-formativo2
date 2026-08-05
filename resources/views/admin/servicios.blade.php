@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
    @php
    $iconos = [
        'Manicure' => '💅',
        'Pedicure' => '👣',
        'Capilar'  => '💆🏽‍♀️',
        'Otros'    => '✨'
    ];
    $grupos = [];
    foreach ($servicios as $s) {
        $categoria = $s->categoria ?? 'Otros';
        $grupos[$categoria][] = $s;
    }
    @endphp

    <h1 style="font-size:22px;font-weight:600;color:#c0375a;margin-bottom:1.5rem">
        💅 Servicios
    </h1>

    <!-- Formulario para Crear Servicio -->
    <div class="card">
        <h2>✨ Crear Nuevo Servicio</h2>
        @if ($errors->any())
            <div style="background:#fcebeb; color:#a32d2d; padding:10px; border-radius:8px; margin-bottom:15px; font-size:13px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.servicios.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Nombre del Servicio</label>
                    <input type="text" name="nombre_servicio" placeholder="Ej. Manicure spa" required value="{{ old('nombre_servicio') }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Categoría</label>
                    <select name="categoria" required style="width: 100%;">
                        <option value="Manicure" {{ old('categoria') === 'Manicure' ? 'selected' : '' }}>Manicure</option>
                        <option value="Pedicure" {{ old('categoria') === 'Pedicure' ? 'selected' : '' }}>Pedicure</option>
                        <option value="Capilar" {{ old('categoria') === 'Capilar' ? 'selected' : '' }}>Capilar</option>
                        <option value="Otros" {{ old('categoria') === 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Precio (COP)</label>
                    <input type="number" name="precio" placeholder="25000" min="0" step="500" required value="{{ old('precio') }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Imagen del Servicio</label>
                    <input type="file" name="imagen" accept="image/*" style="width: 100%; border: 1.5px solid #f4c0d1; border-radius: 8px; padding: 5px; font-family:'Poppins', sans-serif; font-size:13px; background:#fdf0f5; color:#4a2030;">
                </div>
            </div>
            <div class="form-group" style="margin-top: 14px; margin-bottom: 14px;">
                <label>Descripción</label>
                <input type="text" name="descripcion" placeholder="Corte, exfoliación e hidratación..." value="{{ old('descripcion') }}">
            </div>
            <button type="submit" class="btn btn-primary">✦ Registrar Servicio</button>
        </form>
    </div>

    @if (empty($grupos))
        <div class="card">
            <p>No hay servicios registrados.</p>
        </div>
    @else
        @foreach ($grupos as $cat => $items)
            <div class="card">
                <h2>
                    {{ $iconos[$cat] ?? '✨' }} {{ $cat }}
                </h2>

                <div class="tabla-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:70px">Imagen</th>
                                <th style="width:180px">Nombre</th>
                                <th>Descripción (Editable)</th>
                                <th style="width:130px">Precio (COP)</th>
                                <th style="width:160px">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($items as $s)
                                <tr>
                                    <td>
                                        <div style="position:relative; width:45px; height:45px; border-radius:8px; overflow:hidden; border:1.5px solid #f4c0d1; background:#fdf0f5;" title="Click para cambiar imagen">
                                            <img src="{{ asset($s->imagen ?? 'img/default_servicio.png') }}" 
                                                 alt="{{ $s->nombre_servicio }}" 
                                                 style="width:100%; height:100%; object-fit:cover;">
                                            <input 
                                                form="form-editar-{{ $s->id_servicio }}"
                                                type="file" 
                                                name="imagen"
                                                accept="image/*"
                                                style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;"
                                                onchange="this.parentElement.style.borderColor = '#e8527a';"
                                            >
                                        </div>
                                    </td>

                                    <td style="font-weight:600; color:#c0375a; font-size:14px;">
                                        {{ $s->nombre_servicio }}
                                    </td>

                                    <td>
                                        <form 
                                            id="form-editar-{{ $s->id_servicio }}"
                                            action="{{ route('admin.servicios.actualizar') }}" 
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >
                                            @csrf
                                            <input 
                                                type="hidden" 
                                                name="id_servicio" 
                                                value="{{ $s->id_servicio }}"
                                            >

                                            <input 
                                                type="text" 
                                                name="descripcion"
                                                value="{{ $s->descripcion }}"
                                                style="width:100%;padding:6px 10px;border:1.5px solid #f4c0d1;
                                                       border-radius:8px;font-family:'Poppins',sans-serif;font-size:13px;
                                                       background:#fdf0f5;color:#4a2030"
                                            >
                                        </form>
                                    </td>

                                    <td>
                                        <input 
                                            form="form-editar-{{ $s->id_servicio }}"
                                            type="number" 
                                            name="precio"
                                            value="{{ (int)$s->precio }}"
                                            min="0" 
                                            step="500" 
                                            required
                                            style="width:100%;padding:6px 10px;border:1.5px solid #f4c0d1;
                                                   border-radius:8px;font-family:'Poppins',sans-serif;font-size:13px;
                                                   background:#fdf0f5;color:#4a2030;font-weight:600"
                                        >
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            <button 
                                                form="form-editar-{{ $s->id_servicio }}"
                                                type="submit" 
                                                class="btn btn-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                            >
                                                Guardar
                                            </button>

                                            <form 
                                                action="{{ route('admin.servicios.eliminar') }}" 
                                                method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');"
                                                style="margin:0;"
                                            >
                                                @csrf
                                                <input 
                                                    type="hidden" 
                                                    name="id_servicio" 
                                                    value="{{ $s->id_servicio }}"
                                                >
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 6px 10px; font-size: 12px;">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
@endsection
