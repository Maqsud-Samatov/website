<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savat — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { background: #F4F6FA; }
        .nav { position:sticky; top:0; z-index:100; background:rgba(255,255,255,0.96); backdrop-filter:blur(16px); border-bottom:1px solid #EAECF0; padding:0 24px; height:64px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
        .nav-logo { font-size:1.3rem; font-weight:800; color:#111; display:flex; align-items:center; gap:8px; }
        .nav-logo .li { width:32px; height:32px; background:#FF5722; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .nav-back { font-family:var(--font); font-size:0.88rem; font-weight:600; color:#555; background:#F4F6FA; border:1.5px solid #E5E7EB; padding:8px 16px; border-radius:9px; cursor:pointer; transition:all 0.2s; }
        .nav-back:hover { background:#EAECF0; }

        .cart-page { max-width:900px; margin:32px auto; padding:0 20px 60px; }
        .cart-title { font-size:1.5rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:6px; }
        .cart-subtitle { font-size:0.85rem; color:#888; margin-bottom:24px; }

        .cart-layout { display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start; }

        /* ITEMS */
        .cart-items { background:white; border-radius:16px; border:1px solid #EAECF0; overflow:hidden; }
        .cart-items-header { padding:16px 20px; border-bottom:1px solid #F0F2F5; display:flex; align-items:center; justify-content:space-between; }
        .cart-items-title { font-size:0.9rem; font-weight:700; color:#111; }

        .cart-item { display:flex; align-items:center; gap:14px; padding:16px 20px; border-bottom:1px solid #F0F2F5; transition:background 0.15s; }
        .cart-item:last-child { border-bottom:none; }
        .cart-item:hover { background:#FAFBFC; }

        .cart-item-img { width:68px; height:68px; border-radius:12px; object-fit:cover; background:linear-gradient(135deg,#FFF3F0,#FFE0D6); display:flex; align-items:center; justify-content:center; font-size:2rem; flex-shrink:0; overflow:hidden; position:relative; }
        .cart-item-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }

        .cart-item-info { flex:1; min-width:0; }
        .cart-item-name { font-size:0.92rem; font-weight:700; color:#111; margin-bottom:3px; }
        .cart-item-rest { font-size:0.75rem; color:#B0B8C4; }
        .cart-item-price { font-size:0.95rem; font-weight:800; color:#FF5722; margin-top:4px; }

        .cart-item-qty { display:flex; align-items:center; gap:8px; flex-shrink:0; }
        .qty-btn { width:32px; height:32px; border:1.5px solid #E5E7EB; border-radius:8px; background:white; font-size:1.1rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.18s; color:#555; }
        .qty-btn:hover { border-color:#FF5722; color:#FF5722; background:#FFF3F0; }
        .qty-num { font-size:0.95rem; font-weight:700; color:#111; min-width:24px; text-align:center; }

        .cart-item-remove { width:32px; height:32px; border:none; background:#F4F6FA; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:0.9rem; transition:all 0.18s; color:#888; flex-shrink:0; }
        .cart-item-remove:hover { background:#FFF0F0; color:#C62828; }

        /* EMPTY */
        .cart-empty { text-align:center; padding:64px 20px; }
        .cart-empty-icon { font-size:4rem; margin-bottom:16px; }
        .cart-empty h3 { font-size:1.1rem; font-weight:800; color:#111; margin-bottom:8px; }
        .cart-empty p { font-size:0.88rem; color:#888; margin-bottom:20px; }

        /* SUMMARY */
        .cart-summary { background:white; border-radius:16px; border:1px solid #EAECF0; overflow:hidden; position:sticky; top:84px; }
        .summary-header { padding:16px 20px; border-bottom:1px solid #F0F2F5; }
        .summary-title { font-size:0.9rem; font-weight:700; color:#111; }
        .summary-body { padding:18px 20px; }
        .summary-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; font-size:0.88rem; }
        .summary-row .label { color:#888; font-weight:500; }
        .summary-row .value { font-weight:700; color:#111; }
        .summary-divider { height:1px; background:#F0F2F5; margin:14px 0; }
        .summary-total-row { display:flex; justify-content:space-between; align-items:center; }
        .summary-total-label { font-size:0.95rem; font-weight:700; color:#111; }
        .summary-total-value { font-size:1.3rem; font-weight:800; color:#FF5722; }

        .btn-checkout { width:100%; padding:14px; background:linear-gradient(135deg,#FF5722,#FF7043); color:white; border:none; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:700; cursor:pointer; transition:all 0.2s; margin-top:16px; box-shadow:0 4px 14px rgba(255,87,34,0.3); }
        .btn-checkout:hover { transform:translateY(-1px); box-shadow:0 8px 22px rgba(255,87,34,0.38); }

        .btn-clear { width:100%; padding:10px; background:#F4F6FA; color:#888; border:1.5px solid #E5E7EB; border-radius:10px; font-family:var(--font); font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; margin-top:8px; }
        .btn-clear:hover { background:#FFF0F0; color:#C62828; border-color:#FFCDD2; }

        .alert-success { background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9; padding:13px 18px; border-radius:12px; font-size:0.875rem; font-weight:600; margin-bottom:18px; }

        @media (max-width:700px) {
            .cart-layout { grid-template-columns:1fr; }
            .cart-summary { position:static; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <a href="/" class="nav-logo"><div class="li">🔥</div> FoodRush</a>
    <a href="/" class="nav-back">← Orqaga</a>
</nav>

<div class="cart-page">
    <div class="cart-title">🛒 Savat</div>
    <div class="cart-subtitle">{{ $cartItems->count() }} ta mahsulot</div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="cart-empty">
            <div class="cart-empty-icon">🛒</div>
            <h3>Savat bo'sh</h3>
            <p>Hali hech narsa qo'shilmagan. Menyudan taom tanlang!</p>
            <a href="/" style="display:inline-flex; align-items:center; gap:8px; background:#FF5722; color:white; padding:13px 28px; border-radius:12px; font-weight:700; font-size:0.95rem;">
                🍽️ Menyuga o'tish
            </a>
        </div>
    @else
    <div class="cart-layout">
        <!-- ITEMS -->
        <div class="cart-items">
            <div class="cart-items-header">
                <div class="cart-items-title">{{ $cartItems->first()?->restaurant?->name ?? 'Restoran' }}</div>
                <span style="font-size:0.78rem; color:#888;">{{ $cartItems->sum('quantity') }} ta buyum</span>
            </div>

            @foreach($cartItems as $item)
            <div class="cart-item" id="item-{{ $item->id }}">
                <div class="cart-item-img">
                    @if($item->food?->image)
                        <img src="{{ Storage::url($item->food->image) }}" alt="{{ $item->food->name }}">
                    @else
                        🍽️
                    @endif
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">{{ $item->food?->name }}</div>
                    <div class="cart-item-rest">{{ $item->restaurant?->name }}</div>
                    <div class="cart-item-price">
                        {{ number_format(($item->food?->discount_price ?? $item->food?->price) * $item->quantity, 0, '.', ' ') }} so'm
                    </div>
                </div>
                <div class="cart-item-qty">
                    <button class="qty-btn" onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})">−</button>
                    <span class="qty-num" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                    <button class="qty-btn" onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                </div>
                <form method="POST" action="{{ route('user.cart.remove', $item) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="cart-item-remove">🗑️</button>
                </form>
            </div>
            @endforeach
        </div>

        <!-- SUMMARY -->
        <div class="cart-summary">
            <div class="summary-header">
                <div class="summary-title">📋 Buyurtma xulosasi</div>
            </div>
            <div class="summary-body">
                <div class="summary-row">
                    <span class="label">Taomlar narxi</span>
                    <span class="value">{{ number_format($total, 0, '.', ' ') }} so'm</span>
                </div>
                <div class="summary-row">
                    <span class="label">Yetkazish</span>
                    <span class="value">{{ number_format($delivery, 0, '.', ' ') }} so'm</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-total-row">
                    <span class="summary-total-label">Jami</span>
                    <span class="summary-total-value">{{ number_format($total + $delivery, 0, '.', ' ') }} so'm</span>
                </div>

                <a href="{{ route('user.checkout.index') }}">
                    <button class="btn-checkout">⚡ Buyurtma berish</button>
                </a>

                <form method="POST" action="{{ route('user.cart.clear') }}">
                    @csrf
                    <button type="submit" class="btn-clear" onclick="return confirm('Savatni tozalash?')">
                        🗑️ Savatni tozalash
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function updateQty(itemId, qty) {
    fetch(`/user/cart/${itemId}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ quantity: qty })
    }).then(() => location.reload());
}
</script>
</body>
</html>