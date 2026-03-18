<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🔥</div>
        <div>
            <span class="logo-text">FoodRush</span>
            <span class="logo-badge">ADMIN</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Asosiy</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section-label">Boshqaruv</div>
        <a href="{{ route('admin.restaurants.index') }}"
           class="nav-item {{ request()->routeIs('admin.restaurants*') ? 'active' : '' }}">
            <span class="nav-icon">🍽️</span> Restoranlar
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Foydalanuvchilar
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <span class="nav-icon">📦</span> Buyurtmalar
        </a>

        <div class="nav-section-label">Tizim</div>
        <a href="{{ url('/') }}" class="nav-item">
            <span class="nav-icon">🌐</span> Saytga o'tish
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item">
                <span class="nav-icon">🚪</span> Chiqish
            </button>
        </form>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">
            @yield('topbar-actions')
        </div>
    </div>

    <!-- CONTENT -->
    <div class="page-content">
        @if(session('success'))
            <div class="admin-alert admin-alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="admin-alert admin-alert-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>