{{-- <div>
    <li class="pc-item">
        <a href="{{ route($route) }}" class="pc-link {{ $active ?? ''}}">
            <span class="pc-micon"><i class="{{ $icon }}"></i></span>
            <span class="pc-mtext">{{ $title }}</span>
        </a>
    </li>
</div> --}}


<li class="pc-item">
    <a href="{{ isset($route) && Route::has($route) ? route($route) : '#' }}" class="pc-link {{ $active ?? '' }}">
        <span class="pc-micon"><i class="{{ $icon }}"></i></span>
        <span class="pc-mtext">{{ $title }}</span>
    </a>
</li>

{{-- @props(['title', 'icon', 'route'])

@php
    // Dapatkan nama route saat ini
    $currentRoute = Route::currentRouteName();

    // Buat array dari kemungkinan prefix yang cocok
    $activeRoutes = [
        $route,
        $route . '.*', // cocokkan dengan route seperti kandidat.create, kandidat.edit
    ];

    $isActive = false;
    foreach ($activeRoutes as $r) {
        if (request()->routeIs($r)) {
            $isActive = true;
            break;
        }
    }
@endphp

<li class="pc-item {{ $isActive ? 'active' : '' }}">
    <a href="{{ isset($route) && Route::has($route) ? route($route) : '#' }}" class="pc-link">
        <span class="pc-micon"><i class="{{ $icon }}"></i></span>
        <span class="pc-mtext">{{ $title }}</span>
    </a>
</li> --}}
