<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyurtma qabul qilindi — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { background:#F4F6FA; font-family:var(--font); display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px; }
        .success-card { background:white; border-radius:24px; border:1px solid #EAECF0; max-width:520px; width:100%; padding:48px 40px; text-align:center; box-shadow:0 8px 40px rgba(0,0,0,0.08); }
        .success-icon { width:80px; height:80px; background:#E8F5E9; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 24px; }
        .success-title { font-size:1.5rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:8px; }
        .success-sub { font-size:0.9rem; color:#888; margin-bottom:32px; line-height:1.6; }
        .order-num { background:#F4F6FA; border-radius:12px; padding:16px 20px; margin-bottom:28px; }
        .order-num-lbl { font-size:0.75rem; color:#888; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .order-num-val { font-size:1.5rem; font-weight:800; color:#FF5722; }

        .order-details { text-align:left; margin-bottom:28px; }
        .detail-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5; font-size:0.88rem; }
        .detail-row:last-child { border-bottom:none; }
        .detail-lbl { color:#888; }
        .detail-val { font-weight:700; color:#111; }

        .steps { display:flex; justify-content:space-between; margin-bottom:32px; position:relative; }
        .steps::before { content:''; position:absolute; top:16px; left:10%; right:10%; height:2px; background:#E5E7EB; z-index:0; }
        .step { display:flex; flex-direction:column; align-items:center; gap:8px; position:relative; z-index:1; }
        .step-circle { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.9rem; }
        .step-circle.done { background:#E8F5E9; }
        .step-circle.active { background:#FF5722; animation:pulse 2s ease-in-out infinite; }
        .step-circle.pending { background:#F4F6FA; }
        @keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(255,87,34,0.4)} 50%{box-shadow:0 0 0 8px rgba(255,87,34,0)} }
        .step-label { font-size:0.7rem; font-weight:600; color:#888; }
        .step-label.active { color:#FF5722; }

        .btn-home { width:100%; padding:13px; background:#FF5722; color:white; border:none; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:700; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 14px rgba(255,87,34,0.3); margin-bottom:10px; }
        .btn-home:hover { background:#FF7043; transform:translateY(-1px); }
        .btn-track { width:100%; padding:13px; background:#F4F6FA; color:#333; border:1.5px solid #E5E7EB; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
        .btn-track:hover { background:#EAECF0; }
    </style>
</head>
<body>
<div class="success-card">
    <div class="success-icon">✅</div>
    <div class="success-title">Buyurtma qabul qilindi!</div>
    <div class="success-sub">
        Buyurtmangiz qabul qilindi va restoranga yuborildi.
        Tez orada tayyorlanadi!
    </div>

    <div class="order-num">
        <div class="order-num-lbl">Buyurtma raqami</div>
        <div class="order-num-val">#{{ $order->id }}</div>
    </div>

    <!-- Order steps -->
    <div class="steps">
        <div class="step">
            <div class="step-circle done">✅</div>
            <div class="step-label">Qabul qilindi</div>
        </div>
        <div class="step">
            <div class="step-circle active">👨‍🍳</div>
            <div class="step-label active">Tayyorlanmoqda</div>
        </div>
        <div class="step">
            <div class="step-circle pending">🛵</div>
            <div class="step-label">Yo'lda</div>
        </div>
        <div class="step">
            <div class="step-circle pending">🏠</div>
            <div class="step-label">Yetkazildi</div>
        </div>
    </div>

    <div class="order-details">
        <div class="detail-row">
            <span class="detail-lbl">Restoran</span>
            <span class="detail-val">{{ $order->restaurant->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-lbl">Manzil</span>
            <span class="detail-val">{{ $order->address }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-lbl">To'lov usuli</span>
            <span class="detail-val">
                @if($order->payment_method === 'click') 💳 Click
                @elseif($order->payment_method === 'payme') 💳 Payme
                @else 💵 Naqd pul
                @endif
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-lbl">Jami summa</span>
            <span class="detail-val" style="color:#FF5722;">{{ number_format($order->total, 0, '.', ' ') }} so'm</span>
        </div>
        <div class="detail-row">
            <span class="detail-lbl">Yetkazish vaqti</span>
            <span class="detail-val">~{{ $order->restaurant->delivery_time }} daqiqa</span>
        </div>
    </div>

    <a href="/"><button class="btn-home">🏠 Bosh sahifaga qaytish</button></a>
</div>
</body>
</html>