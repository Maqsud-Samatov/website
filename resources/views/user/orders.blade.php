<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyurtmalarim — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        body { background:#F4F6FA; font-family:var(--font); }
        .nav { position:sticky; top:0; z-index:100; background:rgba(255,255,255,0.96); backdrop-filter:blur(16px); border-bottom:1px solid #EAECF0; padding:0 24px; height:64px; display:flex; align-items:center; justify-content:space-between; }
        .nav-logo { font-size:1.3rem; font-weight:800; color:#111; display:flex; align-items:center; gap:8px; text-decoration:none; }
        .nav-logo .li { width:32px; height:32px; background:#FF5722; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .nav-back { font-family:var(--font); font-size:0.88rem; font-weight:600; color:#555; background:#F4F6FA; border:1.5px solid #E5E7EB; padding:8px 16px; border-radius:9px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; gap:6px; }

        .orders-page { max-width:800px; margin:28px auto; padding:0 20px 60px; }
        .page-title { font-size:1.4rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }

        .order-card { background:white; border-radius:16px; border:1px solid #EAECF0; overflow:hidden; margin-bottom:14px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .order-card-header { padding:14px 18px; border-bottom:1px solid #F0F2F5; display:flex; align-items:center; justify-content:space-between; }
        .order-id { font-size:1rem; font-weight:800; color:#FF5722; }
        .order-date { font-size:0.75rem; color:#888; display:flex; align-items:center; gap:3px; }
        .order-card-body { padding:16px 18px; }

        .order-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px; }
        .order-info-item { }
        .order-info-label { font-size:0.7rem; color:#888; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:3px; display:flex; align-items:center; gap:3px; }
        .order-info-label svg { width:11px; height:11px; }
        .order-info-value { font-size:0.88rem; font-weight:700; color:#111; }

        .order-items-mini { background:#FAFBFC; border-radius:10px; padding:10px 12px; margin-bottom:12px; }
        .order-item-row { display:flex; justify-content:space-between; font-size:0.82rem; padding:3px 0; }
        .order-item-row:not(:last-child) { border-bottom:1px solid #F0F2F5; padding-bottom:6px; margin-bottom:3px; }

        .order-footer { display:flex; align-items:center; justify-content:space-between; }
        .order-total { font-size:1.1rem; font-weight:800; color:#FF5722; }

        /* STATUS */
        .order-status { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:50px; font-size:0.75rem; font-weight:700; }
        .order-status svg { width:12px; height:12px; }
        .s-pending    { background:#FFF3E0; color:#E65100; }
        .s-confirmed  { background:#E3F2FD; color:#1565C0; }
        .s-preparing  { background:#F3E5F5; color:#6A1B9A; }
        .s-on_the_way { background:#E8EAF6; color:#283593; }
        .s-delivered  { background:#E8F5E9; color:#2E7D32; }
        .s-cancelled  { background:#FFF0F0; color:#C62828; }

        /* CONFIRM BUTTON */
        .btn-confirm { font-family:var(--font); font-weight:700; font-size:0.85rem; background:linear-gradient(135deg,#2E7D32,#388E3C); color:white; border:none; padding:10px 20px; border-radius:10px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; gap:6px; box-shadow:0 3px 10px rgba(46,125,50,0.3); }
        .btn-confirm:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(46,125,50,0.4); }
        .btn-confirm svg { width:16px; height:16px; }

        .confirmed-badge { display:flex; align-items:center; gap:5px; font-size:0.82rem; font-weight:700; color:#2E7D32; background:#E8F5E9; padding:8px 14px; border-radius:10px; }
        .confirmed-badge svg { width:15px; height:15px; }

        .tracking-bar { display:flex; align-items:center; gap:0; margin-bottom:14px; padding:12px 14px; background:#FAFBFC; border-radius:12px; }
        .track-step { display:flex; flex-direction:column; align-items:center; gap:4px; flex:1; position:relative; }
        .track-step:not(:last-child)::after { content:''; position:absolute; top:14px; left:60%; width:80%; height:2px; background:#E5E7EB; z-index:0; }
        .track-step.done:not(:last-child)::after { background:#FF5722; }
        .track-dot { width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.75rem; z-index:1; border:2px solid #E5E7EB; background:white; }
        .track-dot.done { background:#FF5722; border-color:#FF5722; color:white; }
        .track-dot.active { background:#FFF3E0; border-color:#FF5722; }
        .track-dot svg { width:13px; height:13px; }
        .track-label { font-size:0.62rem; color:#888; font-weight:600; text-align:center; }
        .track-label.done { color:#FF5722; }

        .alert-success { background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9; padding:12px 16px; border-radius:12px; font-size:0.875rem; font-weight:600; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
    </style>
</head>
<body>

<nav class="nav">
    <a href="/" class="nav-logo"><div class="li">🔥</div> FoodRush</a>
    <a href="/" class="nav-back">
        <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        Orqaga
    </a>
</nav>

<div class="orders-page">
    <div class="page-title">
        <i data-lucide="package" style="width:24px;height:24px;color:#FF5722;"></i>
        Buyurtmalarim
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i data-lucide="check-circle" style="width:16px;height:16px;"></i>
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-card-header">
            <div>
                <div class="order-id">#{{ $order->id }}</div>
                <div class="order-date">
                    <i data-lucide="clock" style="width:11px;height:11px;"></i>
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
            <span class="order-status s-{{ $order->status }}">
                {{ match($order->status) {
                    'pending'    => '⏳ Kutilmoqda',
                    'confirmed'  => '✅ Tasdiqlandi',
                    'preparing'  => '👨‍🍳 Tayyorlanmoqda',
                    'on_the_way' => '🛵 Yo\'lda',
                    'delivered'  => '🏠 Yetkazildi',
                    'cancelled'  => '❌ Bekor',
                    default      => $order->status
                } }}
            </span>
        </div>

        <div class="order-card-body">

            <!-- Tracking bar -->
            @php
                $steps = ['pending', 'confirmed', 'preparing', 'on_the_way', 'delivered'];
                $currentIdx = array_search($order->status, $steps);
            @endphp
            @if($order->status !== 'cancelled')
            <div class="tracking-bar">
                @foreach($steps as $i => $step)
                <div class="track-step {{ $i <= $currentIdx ? 'done' : '' }}">
                    <div class="track-dot {{ $i < $currentIdx ? 'done' : ($i === $currentIdx ? 'active' : '') }}">
                        @if($i < $currentIdx)
                            <i data-lucide="check" style="width:13px;height:13px;stroke:white;"></i>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    <div class="track-label {{ $i <= $currentIdx ? 'done' : '' }}">
                        {{ match($step) {
                            'pending'    => 'Qabul',
                            'confirmed'  => 'Tasdiqlandi',
                            'preparing'  => 'Tayyorlanmoqda',
                            'on_the_way' => 'Yo\'lda',
                            'delivered'  => 'Yetkazildi',
                        } }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="order-info-grid">
                <div class="order-info-item">
                    <div class="order-info-label">
                        <i data-lucide="store" style="width:11px;height:11px;"></i> Restoran
                    </div>
                    <div class="order-info-value">{{ $order->restaurant->name }}</div>
                </div>
                <div class="order-info-item">
                    <div class="order-info-label">
                        <i data-lucide="credit-card" style="width:11px;height:11px;"></i> To'lov
                    </div>
                    <div class="order-info-value">
                        {{ match($order->payment_method) {
                            'click' => '💳 Click',
                            'payme' => '💳 Payme',
                            default => '💵 Naqd'
                        } }}
                    </div>
                </div>
            </div>

            <div class="order-items-mini">
                @foreach($order->items as $item)
                <div class="order-item-row">
                    <span style="color:#333; font-weight:600;">{{ $item->food->name }} × {{ $item->quantity }}</span>
                    <span style="color:#FF5722; font-weight:700;">{{ number_format($item->total, 0, '.', ' ') }} so'm</span>
                </div>
                @endforeach
            </div>

            <div class="order-footer">
                <div class="order-total">
                    {{ number_format($order->total, 0, '.', ' ') }} so'm
                </div>

                @if($order->status === 'delivered' && !$order->user_confirmed)
                    <form method="POST" action="{{ route('user.orders.confirm', $order) }}">
                        @csrf
                        <button type="submit" class="btn-confirm">
                            <i data-lucide="package-check" style="width:16px;height:16px;"></i>
                            Qabul qildim ✅
                        </button>
                    </form>
                @elseif($order->user_confirmed)
                    <div class="confirmed-badge">
                        <i data-lucide="check-circle" style="width:15px;height:15px;"></i>
                        Tasdiqlandi
                    </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center; padding:60px 20px; color:#888;">
        <i data-lucide="package-open" style="width:48px;height:48px;color:#ddd;margin:0 auto 14px;display:block;"></i>
        <h3 style="font-size:1rem; font-weight:700; color:#333; margin-bottom:6px;">Buyurtmalar yo'q</h3>
        <p>Hali hech qanday buyurtma bermagansiz</p>
        <a href="/" style="display:inline-flex; align-items:center; gap:6px; background:#FF5722; color:white; padding:11px 22px; border-radius:10px; font-weight:700; font-size:0.9rem; margin-top:16px; text-decoration:none;">
            <i data-lucide="utensils" style="width:16px;height:16px;stroke:white;"></i>
            Menyudan tanlash
        </a>
    </div>
    @endforelse

    {{ $orders->links() }}
</div>

<script>lucide.createIcons();</script>
</body>
</html>