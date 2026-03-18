<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuryer Panel') — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        body { background:#F4F6FA; font-family:var(--font); }

        /* MOBILE-FIRST DELIVERY UI */
        .delivery-app { max-width:480px; margin:0 auto; min-height:100vh; background:#F4F6FA; }

        /* TOP NAV */
        .d-nav {
            background:linear-gradient(135deg,#FF5722,#FF7043);
            padding:16px 20px;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:100;
            box-shadow:0 4px 16px rgba(255,87,34,0.3);
        }
        .d-nav-left { display:flex; align-items:center; gap:10px; }
        .d-nav-avatar {
            width:38px; height:38px; border-radius:50%;
            background:rgba(255,255,255,0.25);
            display:flex; align-items:center; justify-content:center;
            font-weight:800; color:white; font-size:0.9rem;
        }
        .d-nav-name { font-size:0.95rem; font-weight:700; color:white; }
        .d-nav-role { font-size:0.72rem; color:rgba(255,255,255,0.75); }
        .d-nav-right { display:flex; align-items:center; gap:8px; }
        .d-nav-btn {
            background:rgba(255,255,255,0.2);
            border:none; border-radius:10px;
            width:36px; height:36px;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; color:white; transition:all 0.2s;
        }
        .d-nav-btn:hover { background:rgba(255,255,255,0.3); }

        /* STATS BAR */
        .d-stats {
            background:white;
            margin:16px;
            border-radius:16px;
            padding:16px 20px;
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }
        .d-stat { text-align:center; }
        .d-stat-val { font-size:1.6rem; font-weight:800; color:#111; line-height:1; }
        .d-stat-val span { color:#FF5722; }
        .d-stat-lbl { font-size:0.72rem; color:#888; font-weight:600; margin-top:3px; display:flex; align-items:center; justify-content:center; gap:3px; }
        .d-stat-lbl svg { width:11px; height:11px; }
        .d-stat-divider { grid-column:1; border-right:1px solid #F0F2F5; }

        /* SECTION */
        .d-section { padding:0 16px 16px; }
        .d-section-title {
            font-size:0.78rem; font-weight:700;
            text-transform:uppercase; letter-spacing:1.5px;
            color:#888; margin-bottom:12px;
            display:flex; align-items:center; gap:6px;
        }
        .d-section-title svg { width:13px; height:13px; }

        /* ORDER CARD */
        .d-order-card {
            background:white;
            border-radius:16px;
            border:1px solid #EAECF0;
            overflow:hidden;
            margin-bottom:12px;
            box-shadow:0 2px 8px rgba(0,0,0,0.04);
            transition:all 0.2s;
        }
        .d-order-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }

        .d-order-header {
            padding:14px 16px;
            display:flex; align-items:center; justify-content:space-between;
            border-bottom:1px solid #F0F2F5;
        }
        .d-order-id { font-size:1rem; font-weight:800; color:#FF5722; }
        .d-order-time { font-size:0.75rem; color:#888; display:flex; align-items:center; gap:3px; }
        .d-order-time svg { width:11px; height:11px; }

        .d-order-body { padding:14px 16px; }

        .d-info-row {
            display:flex; align-items:flex-start; gap:10px;
            margin-bottom:10px;
        }
        .d-info-icon {
            width:32px; height:32px; border-radius:9px;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; font-size:0.9rem;
        }
        .d-info-icon.red    { background:#FFF0F0; color:#E53E3E; }
        .d-info-icon.blue   { background:#E3F2FD; color:#1565C0; }
        .d-info-icon.green  { background:#E8F5E9; color:#2E7D32; }
        .d-info-icon.orange { background:#FFF3E0; color:#E65100; }
        .d-info-label { font-size:0.7rem; color:#888; font-weight:600; margin-bottom:2px; }
        .d-info-value { font-size:0.88rem; font-weight:700; color:#111; line-height:1.3; }

        .d-order-items {
            background:#FAFBFC;
            border-radius:10px;
            padding:10px 12px;
            margin-bottom:12px;
        }
        .d-order-item {
            display:flex; justify-content:space-between;
            font-size:0.82rem; padding:4px 0;
            border-bottom:1px solid #F0F2F5;
        }
        .d-order-item:last-child { border-bottom:none; }
        .d-order-item-name { color:#333; font-weight:600; }
        .d-order-item-price { color:#FF5722; font-weight:700; }

        .d-order-total {
            display:flex; justify-content:space-between;
            font-size:0.9rem; font-weight:800;
            padding-top:8px;
        }

        /* BUTTONS */
        .d-btn {
            width:100%; padding:13px;
            font-family:var(--font); font-weight:700; font-size:0.9rem;
            border:none; border-radius:12px; cursor:pointer;
            transition:all 0.2s; display:flex;
            align-items:center; justify-content:center; gap:8px;
        }
        .d-btn svg { width:18px; height:18px; }
        .d-btn-accept {
            background:linear-gradient(135deg,#FF5722,#FF7043);
            color:white; box-shadow:0 4px 12px rgba(255,87,34,0.3);
        }
        .d-btn-accept:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(255,87,34,0.4); }
        .d-btn-pickup {
            background:linear-gradient(135deg,#1565C0,#1976D2);
            color:white; box-shadow:0 4px 12px rgba(21,101,192,0.3);
        }
        .d-btn-deliver {
            background:linear-gradient(135deg,#2E7D32,#388E3C);
            color:white; box-shadow:0 4px 12px rgba(46,125,50,0.3);
        }
        .d-btn-delivered {
            background:#E8F5E9; color:#2E7D32;
            border:1.5px solid #C8E6C9;
        }
        .d-btn-row { display:grid; grid-template-columns:1fr 1fr; gap:8px; }

        /* STATUS BADGE */
        .d-status {
            display:inline-flex; align-items:center; gap:4px;
            padding:4px 10px; border-radius:50px;
            font-size:0.72rem; font-weight:700;
        }
        .d-status svg { width:11px; height:11px; }
        .d-status.new       { background:#FFF3E0; color:#E65100; }
        .d-status.on-way    { background:#E3F2FD; color:#1565C0; }
        .d-status.delivered { background:#E8F5E9; color:#2E7D32; }
        .d-status.confirmed { background:#F3E5F5; color:#6A1B9A; }

        /* ALERT */
        .d-alert { margin:0 16px 12px; padding:12px 16px; border-radius:12px; font-size:0.85rem; font-weight:600; display:flex; align-items:center; gap:8px; }
        .d-alert-success { background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9; }
        .d-alert-error   { background:#FFF0F0; color:#C62828; border:1px solid #FFCDD2; }

        /* BOTTOM NAV */
        .d-bottom-nav {
            position:fixed; bottom:0; left:50%; transform:translateX(-50%);
            width:100%; max-width:480px;
            background:white; border-top:1px solid #EAECF0;
            display:flex; padding:8px 0;
            box-shadow:0 -4px 16px rgba(0,0,0,0.06);
            z-index:100;
        }
        .d-bottom-item {
            flex:1; display:flex; flex-direction:column;
            align-items:center; gap:3px; padding:6px;
            text-decoration:none; color:#888; font-size:0.65rem; font-weight:600;
            transition:all 0.2s; border:none; background:none; cursor:pointer;
        }
        .d-bottom-item.active { color:#FF5722; }
        .d-bottom-item svg { width:22px; height:22px; }
        .d-bottom-item .d-badge {
            position:absolute; top:-2px; right:calc(50% - 20px);
            background:#FF5722; color:white; border-radius:50%;
            width:16px; height:16px; font-size:0.6rem; font-weight:700;
            display:flex; align-items:center; justify-content:center;
        }
        .d-bottom-item-wrap { position:relative; }

        .d-page-content { padding-bottom:80px; }

        /* EMPTY */
        .d-empty { text-align:center; padding:48px 20px; color:#888; }
        .d-empty svg { width:48px; height:48px; color:#ddd; margin:0 auto 14px; display:block; }
        .d-empty h3 { font-size:1rem; font-weight:700; color:#333; margin-bottom:6px; }
    </style>
    @stack('styles')
</head>
<body>
<div class="delivery-app">
    @yield('content')

    <!-- BOTTOM NAV -->
    <div class="d-bottom-nav">
        <a href="{{ route('delivery.dashboard') }}" class="d-bottom-item {{ request()->routeIs('delivery.dashboard') ? 'active' : '' }}">
            <div class="d-bottom-item-wrap">
                <i data-lucide="package" style="width:22px;height:22px;"></i>
            </div>
            Buyurtmalar
        </a>
        <a href="{{ route('delivery.history') }}" class="d-bottom-item {{ request()->routeIs('delivery.history') ? 'active' : '' }}">
            <i data-lucide="clock" style="width:22px;height:22px;"></i>
            Tarix
        </a>
        <form method="POST" action="{{ route('logout') }}" style="flex:1;">
            @csrf
            <button type="submit" class="d-bottom-item" style="width:100%;">
                <i data-lucide="log-out" style="width:22px;height:22px;"></i>
                Chiqish
            </button>
        </form>
    </div>
</div>

<script>
lucide.createIcons();
</script>
@stack('scripts')
</body>
</html>