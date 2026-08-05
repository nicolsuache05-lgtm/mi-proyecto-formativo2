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
        ['route' => 'cliente.agendar',           'icon' => '📒', 'label' => 'Agendar cita'],
        ['route' => 'cliente.misReservas',       'icon' => '📅', 'label' => 'Mis reservas'],
        ['route' => 'logout',                    'icon' => '🚪', 'label' => 'Salir'],
      ];
@endphp
<aside style="width:220px;background:white;border-right:1px solid #de7ea9ff;padding:1.5rem 1rem;flex-shrink:0;">
  <nav style="display:flex;flex-direction:column;gap:6px;">
    @foreach ($links as $link)
      <a href="{{ route($link['route']) }}"
         style="display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:12px;
                text-decoration:none;font-size:13px;font-weight:500;
                color:{{ $route === $link['route'] ? '#c0375a' : '#8a5068' }};
                background:{{ $route === $link['route'] ? '#fcebeb' : 'transparent' }};
                transition:background .2s;"
         onmouseover="this.style.background='#fdf0f5'"
         onmouseout="this.style.background='{{ $route === $link['route'] ? '#fcebeb' : 'transparent' }}'">
        <span style="font-size:16px;">{{ $link['icon'] }}</span>
        {{ $link['label'] }}
      </a>
    @endforeach
  </nav>
</aside>
