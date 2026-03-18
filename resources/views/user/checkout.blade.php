<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyurtma berish — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { background: #F4F6FA; font-family: var(--font); }

        .nav { position:sticky; top:0; z-index:100; background:rgba(255,255,255,0.96); backdrop-filter:blur(16px); border-bottom:1px solid #EAECF0; padding:0 24px; height:64px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
        .nav-logo { font-size:1.3rem; font-weight:800; color:#111; display:flex; align-items:center; gap:8px; }
        .nav-logo .li { width:32px; height:32px; background:#FF5722; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .nav-back { font-family:var(--font); font-size:0.88rem; font-weight:600; color:#555; background:#F4F6FA; border:1.5px solid #E5E7EB; padding:8px 16px; border-radius:9px; cursor:pointer; transition:all 0.2s; }
        .nav-back:hover { background:#EAECF0; }

        .checkout-page { max-width:1000px; margin:32px auto; padding:0 20px 60px; }
        .checkout-title { font-size:1.5rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:6px; }
        .checkout-sub { font-size:0.85rem; color:#888; margin-bottom:24px; }

        .checkout-layout { display:grid; grid-template-columns:1fr 360px; gap:22px; align-items:start; }

        /* FORM CARD */
        .checkout-form-card { background:white; border-radius:16px; border:1px solid #EAECF0; overflow:hidden; }
        .checkout-section { padding:22px 24px; border-bottom:1px solid #F0F2F5; }
        .checkout-section:last-child { border-bottom:none; }
        .checkout-section-title { font-size:0.88rem; font-weight:700; color:#111; margin-bottom:18px; display:flex; align-items:center; gap:8px; }

        .form-group { margin-bottom:16px; }
        .form-label { display:block; font-size:0.8rem; font-weight:700; color:#333; margin-bottom:7px; }
        .form-input { width:100%; padding:11px 14px; border:1.5px solid #E5E7EB; border-radius:10px; font-family:var(--font); font-size:0.9rem; color:#333; background:white; transition:all 0.2s; }
        .form-input:focus { outline:none; border-color:#FF5722; box-shadow:0 0 0 3px rgba(255,87,34,0.1); }
        .form-input::placeholder { color:#B0B8C4; }
        textarea.form-input { min-height:80px; resize:vertical; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

        /* PAYMENT METHODS */
        .payment-methods { display:flex; flex-direction:column; gap:10px; }
        .payment-method { display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid #E5E7EB; border-radius:12px; cursor:pointer; transition:all 0.2s; }
        .payment-method:hover { border-color:#FF5722; background:#FFF3F0; }
        .payment-method.selected { border-color:#FF5722; background:#FFF3F0; }
        .payment-method input[type="radio"] { display:none; }
        .payment-radio { width:20px; height:20px; border:2px solid #E5E7EB; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.2s; }
        .payment-method.selected .payment-radio { border-color:#FF5722; background:#FF5722; }
        .payment-method.selected .payment-radio::after { content:''; width:8px; height:8px; background:white; border-radius:50%; display:block; }
        .payment-icon { width:44px; height:28px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; font-weight:800; flex-shrink:0; }
        .payment-icon.click  { background:#00AAEE; color:white; font-size:0.7rem; }
        .payment-icon.payme  { background:#00CCAA; color:white; font-size:0.7rem; }
        .payment-icon.cash   { background:#E8F5E9; color:#2E7D32; font-size:1.2rem; }
        .payment-info {}
        .payment-name { font-size:0.9rem; font-weight:700; color:#111; }
        .payment-desc { font-size:0.75rem; color:#888; margin-top:2px; }
        .payment-badge { margin-left:auto; padding:3px 9px; border-radius:50px; font-size:0.68rem; font-weight:700; }
        .payment-badge.popular { background:#FFF3E0; color:#E65100; }
        .payment-badge.instant { background:#E8F5E9; color:#2E7D32; }

        /* ORDER SUMMARY */
        .summary-card { background:white; border-radius:16px; border:1px solid #EAECF0; overflow:hidden; position:sticky; top:84px; }
        .summary-header { padding:16px 20px; border-bottom:1px solid #F0F2F5; }
        .summary-title { font-size:0.9rem; font-weight:700; color:#111; }
        .summary-rest { font-size:0.78rem; color:#888; margin-top:2px; }

        .summary-items { max-height:280px; overflow-y:auto; }
        .summary-item { display:flex; align-items:center; gap:10px; padding:12px 18px; border-bottom:1px solid #F0F2F5; }
        .summary-item:last-child { border-bottom:none; }
        .summary-item-img { width:44px; height:44px; border-radius:9px; object-fit:cover; background:linear-gradient(135deg,#FFF3F0,#FFE0D6); display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; overflow:hidden; position:relative; }
        .summary-item-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
        .summary-item-name { font-size:0.85rem; font-weight:700; color:#111; flex:1; }
        .summary-item-qty { font-size:0.75rem; color:#888; }
        .summary-item-price { font-size:0.88rem; font-weight:700; color:#FF5722; white-space:nowrap; }

        .summary-calc { padding:16px 18px; border-top:1px solid #F0F2F5; }
        .summary-row { display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:8px; }
        .summary-row .lbl { color:#888; }
        .summary-row .val { font-weight:600; color:#111; }
        .summary-divider { height:1px; background:#F0F2F5; margin:10px 0; }
        .summary-total { display:flex; justify-content:space-between; align-items:center; }
        .summary-total-lbl { font-size:0.95rem; font-weight:700; color:#111; }
        .summary-total-val { font-size:1.3rem; font-weight:800; color:#FF5722; }

        .btn-checkout { width:100%; padding:14px; background:linear-gradient(135deg,#FF5722,#FF7043); color:white; border:none; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:700; cursor:pointer; transition:all 0.2s; margin-top:14px; box-shadow:0 4px 14px rgba(255,87,34,0.3); }
        .btn-checkout:hover { transform:translateY(-1px); box-shadow:0 8px 22px rgba(255,87,34,0.38); }

        .commission-note { font-size:0.72rem; color:#B0B8C4; text-align:center; margin-top:8px; }

        .alert-error { background:#FFF0F0; color:#C62828; border:1px solid #FFCDD2; padding:13px 18px; border-radius:12px; font-size:0.875rem; font-weight:600; margin-bottom:18px; }

        @media (max-width:768px) {
            .checkout-layout { grid-template-columns:1fr; }
            .summary-card { position:static; }
            .form-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <a href="/" class="nav-logo"><div class="li">🔥</div> FoodRush</a>
    <a href="{{ route('user.cart.index') }}" class="nav-back">← Savatga qaytish</a>
</nav>

<div class="checkout-page">
    <div class="checkout-title">📋 Buyurtma berish</div>
    <div class="checkout-sub">Ma'lumotlaringizni to'ldiring va to'lov usulini tanlang</div>

    @if(session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('user.checkout.store') }}" id="checkoutForm">
        @csrf
        <div class="checkout-layout">

            <!-- LEFT: FORM -->
            <div>
                <!-- Yetkazish manzili -->
                <div class="checkout-form-card">
                    <div class="checkout-section">
                        <div class="checkout-section-title">📍 Yetkazish manzili</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Telefon raqam *</label>
                                <input type="text" name="phone" class="form-input"
                                    placeholder="+998 90 123 45 67"
                                    value="{{ old('phone', $user->phone ?? '') }}" required>
                                @error('phone')<div style="color:#C62828;font-size:0.75rem;margin-top:4px;">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">To'liq manzil *</label>
                                <input type="text" name="address" class="form-input"
                                    placeholder="Ko'cha, uy raqami, xonadon"
                                    value="{{ old('address', $user->address ?? '') }}" required>
                                @error('address')<div style="color:#C62828;font-size:0.75rem;margin-top:4px;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Izoh (ixtiyoriy)</label>
                            <textarea name="note" class="form-input" placeholder="Kuryer uchun qo'shimcha ma'lumot...">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <!-- To'lov usuli -->
                    <div class="checkout-section">
                        <div class="checkout-section-title">💳 To'lov usuli</div>
                        <div class="payment-methods">

                            <label class="payment-method selected" id="pm-click" onclick="selectPayment('click')">
                                <input type="radio" name="payment_method" value="click" checked>
                                <div class="payment-radio"></div>
                                <div class="payment-icon click">CLICK</div>
                                <div class="payment-info">
                                    <div class="payment-name">Click</div>
                                    <div class="payment-desc">Uzcard, Humo, Visa, Mastercard</div>
                                </div>
                                <span class="payment-badge popular">Mashhur</span>
                            </label>

                            <label class="payment-method" id="pm-payme" onclick="selectPayment('payme')">
                                <input type="radio" name="payment_method" value="payme">
                                <div class="payment-radio"></div>
                                <div class="payment-icon payme">PAYME</div>
                                <div class="payment-info">
                                    <div class="payment-name">Payme</div>
                                    <div class="payment-desc">Uzcard, Humo, Visa, Mastercard</div>
                                </div>
                                <span class="payment-badge popular">Mashhur</span>
                            </label>

                            <label class="payment-method" id="pm-cash" onclick="selectPayment('cash')">
                                <input type="radio" name="payment_method" value="cash">
                                <div class="payment-radio"></div>
                                <div class="payment-icon cash">💵</div>
                                <div class="payment-info">
                                    <div class="payment-name">Naqd pul</div>
                                    <div class="payment-desc">Yetkazib berganda to'lang</div>
                                </div>
                                <span class="payment-badge instant">Qulay</span>
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: SUMMARY -->
            <div class="summary-card">
                <div class="summary-header">
                    <div class="summary-title">🧾 Buyurtma tarkibi</div>
                    <div class="summary-rest">{{ $restaurant->name }}</div>
                </div>

                <div class="summary-items">
                    @foreach($cartItems as $item)
                    <div class="summary-item">
                        <div class="summary-item-img">
                            @if($item->food?->image)
                                <img src="{{ Storage::url($item->food->image) }}">
                            @else 🍽️ @endif
                        </div>
                        <div class="summary-item-name">{{ $item->food?->name }}</div>
                        <div class="summary-item-qty">×{{ $item->quantity }}</div>
                        <div class="summary-item-price">
                            {{ number_format(($item->food?->discount_price ?? $item->food?->price) * $item->quantity, 0, '.', ' ') }} so'm
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="summary-calc">
                    <div class="summary-row">
                        <span class="lbl">Taomlar</span>
                        <span class="val">{{ number_format($subtotal, 0, '.', ' ') }} so'm</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Yetkazish</span>
                        <span class="val">{{ number_format($delivery, 0, '.', ' ') }} so'm</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <span class="summary-total-lbl">Jami</span>
                        <span class="summary-total-val">{{ number_format($total, 0, '.', ' ') }} so'm</span>
                    </div>

                    <button type="submit" class="btn-checkout" id="checkoutBtn">
                        ⚡ Buyurtma berish
                    </button>
                    <div class="commission-note">🔒 Xavfsiz to'lov • SSL himoyalangan</div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function selectPayment(method) {
    document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
    document.getElementById('pm-' + method).classList.add('selected');
    document.querySelector(`input[value="${method}"]`).checked = true;

    const btn = document.getElementById('checkoutBtn');
    if (method === 'click') btn.textContent = '⚡ Click orqali to\'lash';
    else if (method === 'payme') btn.textContent = '⚡ Payme orqali to\'lash';
    else btn.textContent = '✅ Buyurtma berish';
}
</script>

</body>
</html>