@php
$isAdmin = Auth::guard('admin')->check();
$route = Route::currentRouteName();
$links = $isAdmin
    ? [
        ['route' => 'admin.dashboard',           'icon' => '📊', 'label' => 'Dashboard'],
        ['route' => 'admin.reservas',            'icon' => '📅', 'label' => 'Reservas'],
        ['route' => 'admin.clientes',            'icon' => '👥', 'label' => 'Clientes'],
        ['route' => 'admin.servicios',           'icon' => '💅', 'label' => 'Servicios'],
        ['route' => 'admin.pagos',               'icon' => '💰', 'label' => 'Pagos'],
        ['route' => 'logout',                    'icon' => '🚪', 'label' => 'Salir'],
      ]
    : [
        ['route' => 'cliente.dashboard',         'icon' => '🏠', 'label' => 'Inicio'],
        ['route' => 'cliente.catalogo',          'icon' => '📖', 'label' => 'Catálogo'],
        ['route' => 'cliente.agendar',           'icon' => '📒', 'label' => 'Agendar cita'],
        ['route' => 'cliente.misReservas',       'icon' => '📅', 'label' => 'Mis reservas'],
        ['route' => 'cliente.pago',              'icon' => '💳', 'label' => 'Pago'],
        ['route' => 'logout',                    'icon' => '🚪', 'label' => 'Salir'],
      ];
@endphp
<aside style="width:260px;background:white;border-right:1px solid #de7ea9ff;padding:2rem 1.25rem;flex-shrink:0;">
  <nav style="display:flex;flex-direction:column;gap:10px;">
    @foreach ($links as $link)
      <a href="{{ route($link['route']) }}"
         style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:12px;
                text-decoration:none;font-size:15px;font-weight:600;
                color:{{ $route === $link['route'] ? '#c0375a' : '#8a5068' }};
                background:{{ $route === $link['route'] ? '#fcebeb' : 'transparent' }};
                transition:background .2s;"
         onmouseover="this.style.background='#fdf0f5'"
         onmouseout="this.style.background='{{ $route === $link['route'] ? '#fcebeb' : 'transparent' }}'">
        <span style="font-size:20px;">{{ $link['icon'] }}</span>
        {{ $link['label'] }}
      </a>
    @endforeach
  </nav>
</aside>
