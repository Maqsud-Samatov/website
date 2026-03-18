<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To'lov muvaffaqiyatsiz — FoodRush</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { background:#F4F6FA; font-family:var(--font); display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px; }
        .failed-card { background:white; border-radius:24px; border:1px solid #EAECF0; max-width:460px; width:100%; padding:48px 40px; text-align:center; box-shadow:0 8px 40px rgba(0,0,0,0.08); }
        .failed-icon { width:80px; height:80px; background:#FFF0F0; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 24px; }
        .failed-title { font-size:1.5rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:8px; }
        .failed-sub { font-size:0.9rem; color:#888; margin-bottom:32px; line-height:1.6; }
        .order-num { background:#FFF0F0; border-radius:12px; padding:16px 20px; margin-bottom:28px; }
        .order-num-lbl { font-size:0.75rem; color:#C62828; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .order-num-val { font-size:1.5rem; font-weight:800; color:#C62828; }
        .btn-retry { width:100%; padding:13px; background:#FF5722; color:white; border:none; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:700; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 14px rgba(255,87,34,0.3); margin-bottom:10px; }
        .btn-retry:hover { background:#FF7043; transform:translateY(-1px); }
        .btn-home { width:100%; padding:13px; background:#F4F6FA; color:#333; border:1.5px solid #E5E7EB; border-radius:12px; font-family:var(--font); font-size:0.95rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
        .btn-home:hover { background:#EAECF0; }
    </style>
</head>
<body>
<div class="failed-card">
    <div class="failed-icon">❌</div>
    <div class="failed-title">To'lov amalga oshmadi</div>
    <div class="failed-sub">
        To'lov jarayonida xatolik yuz berdi yoki bekor qilindi.
        Qayta urinib ko'ring.
    </div>

    <div class="order-num">
        <div class="order-num-lbl">Buyurtma raqami</div>
        <div class="order-num-val">#{{ $order->id }}</div>
    </div>

    <a href="{{ route('user.checkout.index') }}">
        <button class="btn-retry">🔄 Qayta to'lash</button>
    </a>
    <a href="/"><button class="btn-home">🏠 Bosh sahifaga qaytish</button></a>
</div>
</body>
</html>