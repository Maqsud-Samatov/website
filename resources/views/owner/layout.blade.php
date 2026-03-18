<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Owner Panel') — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    @stack('styles')
</head>
<body class="owner-body">

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🔥</div>
        <div>
            <span class="logo-text">FoodRush</span>
            <span class="logo-badge" style="background:#FF9800;">OWNER</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-label">Asosiy</div>
        <a href="{{ route('owner.dashboard') }}" class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <div class="nav-section-label">Menyu</div>
        <a href="{{ route('owner.menu.index') }}" class="nav-item {{ request()->routeIs('owner.menu*') ? 'active' : '' }}">
            <span class="nav-icon">🍽️</span> Menyu & Taomlar
        </a>
        <div class="nav-section-label">Buyurtmalar</div>
        <a href="#" class="nav-item">
            <span class="nav-icon">📦</span> Buyurtmalar
        </a>
        <div class="nav-section-label">Tizim</div>
        <a href="{{ url('/') }}" class="nav-item"><span class="nav-icon">🌐</span> Saytga o'tish</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item"><span class="nav-icon">🚪</span> Chiqish</button>
        </form>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Restoran egasi</div>
            </div>
        </div>
    </div>
</aside>

<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">@yield('topbar-actions')</div>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="owner-alert owner-alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="owner-alert owner-alert-error">❌ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>