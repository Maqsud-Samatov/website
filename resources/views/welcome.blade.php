<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodRush — Tez va Mazali Yetkazib Berish</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        /* NAV */
        .nav { position:sticky; top:0; z-index:200; background:rgba(255,255,255,0.96); backdrop-filter:blur(16px); border-bottom:1px solid #EAECF0; padding:0 40px; height:66px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
        .nav-logo { font-size:1.45rem; font-weight:800; color:#111; display:flex; align-items:center; gap:9px; letter-spacing:-0.5px; text-decoration:none; }
        .nav-logo .logo-icon { width:36px; height:36px; background:linear-gradient(135deg,#FF5722,#FF8A65); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.05rem; box-shadow:0 4px 12px rgba(255,87,34,0.3); }
        .nav-right { display:flex; align-items:center; gap:10px; }
        .btn-nav-ghost { font-family:var(--font); font-weight:600; font-size:0.88rem; color:#444; background:transparent; border:1.5px solid #E5E7EB; padding:9px 20px; border-radius:10px; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; }
        .btn-nav-ghost:hover { border-color:#ccc; background:#F4F6FA; }
        .btn-nav-primary { font-family:var(--font); font-weight:700; font-size:0.88rem; color:white; background:linear-gradient(135deg,#FF5722,#FF7043); border:none; padding:10px 22px; border-radius:10px; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; }
        .btn-nav-primary:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(255,87,34,0.3); }
        .cart-nav-btn { position:relative; display:flex; align-items:center; justify-content:center; width:42px; height:42px; background:#FFF3F0; border:1.5px solid #FFCBB8; border-radius:10px; cursor:pointer; transition:all 0.2s; text-decoration:none; color:#FF5722; }
        .cart-nav-btn:hover { background:#FF5722; color:white; border-color:#FF5722; }
        .cart-nav-badge { position:absolute; top:-6px; right:-6px; background:#FF5722; color:white; border-radius:50%; width:19px; height:19px; font-size:0.65rem; font-weight:700; display:flex; align-items:center; justify-content:center; border:2px solid white; }
        .cart-nav-btn:hover .cart-nav-badge { background:#111; }

        /* HAMBURGER */
        .hamburger-btn { display:none; width:40px; height:40px; background:transparent; border:1.5px solid #E5E7EB; border-radius:10px; cursor:pointer; align-items:center; justify-content:center; color:#444; transition:all 0.2s; flex-shrink:0; }
        .hamburger-btn:hover { background:#F4F6FA; }
        .mobile-menu { display:none; position:fixed; top:66px; left:0; right:0; background:white; border-bottom:1px solid #EAECF0; padding:12px 16px 16px; z-index:199; box-shadow:0 8px 24px rgba(0,0,0,0.1); flex-direction:column; gap:8px; animation:slideDown 0.2s ease; }
        .mobile-menu.open { display:flex; }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .mob-item { display:flex; align-items:center; gap:10px; padding:13px 16px; border-radius:12px; font-family:var(--font); font-weight:600; font-size:0.92rem; color:#333; text-decoration:none; background:#F4F6FA; border:none; cursor:pointer; transition:all 0.2s; width:100%; text-align:left; }
        .mob-item:hover { background:#EAECF0; }
        .mob-item.primary { background:linear-gradient(135deg,#FF5722,#FF7043); color:white; }
        .mob-item.primary:hover { opacity:0.92; }
        .mob-item.danger { background:#FFF0F0; color:#C62828; }
        .mob-item svg { width:18px; height:18px; flex-shrink:0; }
        .mob-divider { height:1px; background:#F0F2F5; margin:4px 0; }
        @media (max-width:576px) {
            .nav { padding:0 16px; }
            .nav-desktop { display:none !important; }
            .hamburger-btn { display:flex; }
        }
        @media (min-width:577px) {
            .mobile-menu { display:none !important; }
        }

        /* HERO */
        .hero { max-width:1200px; margin:0 auto; padding:70px 40px 50px; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; }

        .hero-tag { display:inline-flex; align-items:center; gap:6px; background:#E8F5E9; color:#2E7D32; padding:6px 14px; border-radius:50px; font-size:0.78rem; font-weight:700; margin-bottom:22px; }
        .live-dot { width:7px; height:7px; background:#00C853; border-radius:50%; animation:blink 1.5s ease-in-out infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

        .hero-title { font-size:clamp(2.2rem,4vw,3.6rem); font-weight:800; line-height:1.12; letter-spacing:-1.5px; color:#111; margin-bottom:18px; }
        .hero-title .highlight { color:#FF5722; }
        .hero-desc { font-size:1rem; color:#888; line-height:1.75; margin-bottom:32px; max-width:420px; }
        .hero-cta { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:44px; }

        .btn-hero-p { font-family:var(--font); font-weight:700; font-size:1rem; color:white; background:linear-gradient(135deg,#FF5722,#FF7043); border:none; padding:14px 30px; border-radius:14px; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 16px rgba(255,87,34,0.3); }
        .btn-hero-p:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(255,87,34,0.4); }
        .btn-hero-s { font-family:var(--font); font-weight:600; font-size:1rem; color:#333; background:#F4F6FA; border:1.5px solid #E5E7EB; padding:14px 26px; border-radius:14px; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:8px; }
        .btn-hero-s:hover { background:#EAECF0; }

        .hero-stats { display:flex; gap:28px; }
        .h-sv { font-size:1.5rem; font-weight:800; color:#111; line-height:1; }
        .h-sv span { color:#FF5722; }
        .h-sl { font-size:0.75rem; color:#888; font-weight:500; margin-top:3px; }
        .h-sd { width:1px; background:#E5E7EB; align-self:stretch; }

        /* ── HERO VISUAL ── */
        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 440px;
        }

        /* Main burger card */
        .visual-main {
            width: 360px;
            height: 360px;
            background: linear-gradient(145deg, #FF6B35 0%, #FF8E53 40%, #FFA07A 70%, #FFB347 100%);
            border-radius: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11rem;
            position: relative;
            z-index: 2;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.3) inset,
                0 30px 80px rgba(255,107,53,0.45),
                0 10px 30px rgba(255,87,34,0.3),
                0 0 60px rgba(255,140,0,0.2);
            animation: heroFloat 4s ease-in-out infinite;
        }

        .visual-main::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 36px;
            background: linear-gradient(145deg, rgba(255,255,255,0.25) 0%, transparent 60%);
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px) rotate(1.5deg); }
            50%       { transform: translateY(-16px) rotate(-1.5deg); }
        }

        /* Glow behind main card */
        .visual-glow {
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255,107,53,0.3) 0%, rgba(255,140,0,0.15) 50%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
            animation: glowPulse 4s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50%       { transform: scale(1.15); opacity: 1; }
        }

        /* Float chips */
        .float-chip {
            position: absolute;
            background: white;
            border-radius: 16px;
            padding: 12px 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10;
            border: 1px solid rgba(255,255,255,0.8);
        }

        .float-chip-1 {
            top: 20px;
            right: -20px;
            animation: chip1Float 4s ease-in-out infinite;
        }
        .float-chip-2 {
            bottom: 20px;
            left: -20px;
            animation: chip2Float 4s ease-in-out infinite;
        }

        @keyframes chip1Float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50%       { transform: translateY(-8px) translateX(4px); }
        }
        @keyframes chip2Float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50%       { transform: translateY(8px) translateX(-4px); }
        }

        .chip-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .chip-icon.orange { background: linear-gradient(135deg,#FF6B35,#FF8E53); }
        .chip-icon.green  { background: linear-gradient(135deg,#00C853,#69F0AE); }
        .chip-icon svg { width:18px; height:18px; color:white; stroke:white; }

        .chip-title { font-size: 0.78rem; font-weight: 700; color: #111; line-height:1; }
        .chip-sub   { font-size: 0.68rem; color: #888; margin-top: 2px; }

        /* Floating dots decoration */
        .dot-decor {
            position: absolute;
            border-radius: 50%;
            animation: dotFloat 6s ease-in-out infinite;
        }
        .dot-1 { width:12px; height:12px; background:#FF8E53; opacity:0.6; top:40px; left:20px; animation-delay:0s; z-index:3; }
        .dot-2 { width:8px; height:8px; background:#FFB347; opacity:0.5; bottom:60px; right:10px; animation-delay:1s; z-index:3; }
        .dot-3 { width:16px; height:16px; background:#FF6B35; opacity:0.3; top:160px; left:-10px; animation-delay:2s; z-index:3; }
        @keyframes dotFloat {
            0%,100% { transform:translateY(0); }
            50%      { transform:translateY(-10px); }
        }

        /* ── FLOATING FOOD ITEMS ── */
        .food-float {
            position: absolute;
            z-index: 10;
            font-size: 2.4rem;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.15));
            animation: foodFloat 5s ease-in-out infinite;
            user-select: none;
            pointer-events: none;
        }
        /* Soda yuqori chap */
        .food-float-1 {
            top: 10px; left: -10px;
            animation-delay: 0s;
            transform-origin: center;
        }
        /* Kartoshka o'ng pastki */
        .food-float-2 {
            bottom: 30px; right: -15px;
            animation-delay: 1.2s;
        }
        /* Pizza yuqori o'ng */
        .food-float-3 {
            top: 30px; right: -20px;
            animation-delay: 0.6s;
            font-size: 2rem;
        }
        /* Donut pastki chap */
        .food-float-4 {
            bottom: 10px; left: -15px;
            animation-delay: 1.8s;
            font-size: 2rem;
        }
        @keyframes foodFloat {
            0%,100% { transform: translateY(0px) rotate(-5deg); }
            50%      { transform: translateY(-14px) rotate(5deg); }
        }

        /* TRUST */
        .trust-strip { border-top:1px solid #EAECF0; border-bottom:1px solid #EAECF0; padding:20px 40px; display:flex; align-items:center; justify-content:center; gap:12px; flex-wrap:wrap; background:#FAFBFC; }
        .trust-label { font-size:0.75rem; color:#888; font-weight:700; text-transform:uppercase; letter-spacing:1px; display:flex; align-items:center; gap:5px; }
        .trust-badge { background:white; border:1px solid #EAECF0; border-radius:50px; padding:7px 15px; font-size:0.82rem; font-weight:600; color:#444; box-shadow:0 1px 4px rgba(0,0,0,0.05); display:flex; align-items:center; gap:6px; }
        .trust-badge svg { width:14px; height:14px; }

        /* SECTION */
        .restaurants-section { max-width:1280px; margin:0 auto; padding:50px 40px 80px; }
        .section-eyebrow { font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#FF5722; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
        .section-title-main { font-size:clamp(1.6rem,3vw,2.2rem); font-weight:800; letter-spacing:-1px; color:#111; line-height:1.15; margin-bottom:24px; }

        /* TABS */
        .rest-tabs { display:flex; gap:10px; overflow-x:auto; padding-bottom:6px; margin-bottom:28px; scrollbar-width:none; }
        .rest-tabs::-webkit-scrollbar { display:none; }
        .rest-tab { display:flex; align-items:center; gap:8px; padding:10px 18px; border-radius:50px; border:1.5px solid #E5E7EB; background:white; cursor:pointer; transition:all 0.2s; white-space:nowrap; font-family:var(--font); font-size:0.875rem; font-weight:600; color:#555; flex-shrink:0; }
        .rest-tab:hover { border-color:#FF5722; color:#FF5722; background:#FFF3F0; }
        .rest-tab.active { background:#FF5722; border-color:#FF5722; color:white; box-shadow:0 4px 14px rgba(255,87,34,0.28); }
        .rest-tab svg { width:16px; height:16px; }
        .rest-tab-img { width:26px; height:26px; border-radius:7px; object-fit:cover; }
        .rest-tab-emoji { width:26px; height:26px; border-radius:7px; background:#FFF3F0; display:flex; align-items:center; justify-content:center; font-size:0.95rem; }
        .rest-panel { display:none; }
        .rest-panel.active { display:block; }

        .rest-info-bar { background:white; border:1px solid #EAECF0; border-radius:16px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .rest-info-left { display:flex; align-items:center; gap:13px; }
        .rest-info-logo { width:48px; height:48px; border-radius:13px; background:#FFF3F0; display:flex; align-items:center; justify-content:center; font-size:1.5rem; border:1px solid #EAECF0; overflow:hidden; }
        .rest-info-logo img { width:100%; height:100%; object-fit:cover; }
        .rest-info-name { font-size:1rem; font-weight:800; color:#111; margin-bottom:4px; }
        .rest-info-meta { display:flex; gap:12px; flex-wrap:wrap; }
        .rest-info-meta span { font-size:0.76rem; color:#888; font-weight:500; display:flex; align-items:center; gap:4px; }
        .rest-info-meta svg { width:12px; height:12px; }
        .rest-open-badge { padding:5px 13px; border-radius:50px; font-size:0.73rem; font-weight:700; display:flex; align-items:center; gap:4px; }
        .rest-open-badge.open  { background:#E8F5E9; color:#2E7D32; }
        .rest-open-badge.closed { background:#FFF0F0; color:#C62828; }

        .cat-filter { display:flex; gap:8px; overflow-x:auto; padding-bottom:4px; margin-bottom:18px; scrollbar-width:none; }
        .cat-filter::-webkit-scrollbar { display:none; }
        .cat-btn { padding:7px 15px; border-radius:50px; border:1.5px solid #E5E7EB; background:white; font-family:var(--font); font-size:0.8rem; font-weight:600; color:#555; cursor:pointer; transition:all 0.18s; white-space:nowrap; flex-shrink:0; display:flex; align-items:center; gap:5px; }
        .cat-btn:hover { border-color:#FF5722; color:#FF5722; }
        .cat-btn.active { background:#FFF3F0; border-color:#FF5722; color:#FF5722; font-weight:700; }

        /* FOOD CARDS */
        .menu-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:16px; }
        .menu-card { background:white; border:1px solid #EAECF0; border-radius:16px; overflow:hidden; transition:all 0.25s; cursor:pointer; }
        .menu-card:hover { transform:translateY(-4px); box-shadow:0 16px 40px rgba(0,0,0,0.09); border-color:transparent; }
        .menu-card-img { width:100%; height:170px; position:relative; overflow:hidden; background:linear-gradient(135deg,#FFF3F0,#FFE0D6); display:flex; align-items:center; justify-content:center; font-size:4rem; }
        .menu-card-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform 0.4s; }
        .menu-card:hover .menu-card-img img { transform:scale(1.05); }
        .menu-popular { position:absolute; top:10px; left:10px; z-index:2; background:linear-gradient(135deg,#FF5722,#FF7043); color:white; font-size:0.62rem; font-weight:700; padding:3px 9px; border-radius:50px; display:flex; align-items:center; gap:3px; }
        .menu-card-body { padding:13px 15px; }
        .menu-card-name { font-size:0.92rem; font-weight:700; color:#111; margin-bottom:4px; line-height:1.3; }
        .menu-card-desc { font-size:0.76rem; color:#888; line-height:1.5; margin-bottom:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .menu-card-footer { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
        .menu-card-price { font-size:1.1rem; font-weight:800; color:#FF5722; }
        .menu-card-price .old { font-size:0.76rem; color:#B0B8C4; text-decoration:line-through; margin-left:4px; }
        .menu-card-meta { font-size:0.7rem; color:#B0B8C4; display:flex; align-items:center; gap:3px; }
        .menu-card-meta svg { width:11px; height:11px; }
        .btn-open-modal { width:100%; font-family:var(--font); font-weight:700; font-size:0.85rem; background:linear-gradient(135deg,#FF5722,#FF7043); color:white; border:none; padding:10px; border-radius:10px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 3px 10px rgba(255,87,34,0.25); }
        .btn-open-modal:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(255,87,34,0.35); }
        .btn-open-modal svg { width:16px; height:16px; }

        /* FOOD DETAIL MODAL */
        .food-modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1000; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(5px); }
        .food-modal-backdrop.open { display:flex; }
        .food-modal { background:white; border-radius:20px; width:100%; max-width:720px; max-height:90vh; overflow-y:auto; box-shadow:0 32px 80px rgba(0,0,0,0.18); animation:mIn 0.22s ease; }
        @keyframes mIn { from{opacity:0;transform:scale(0.95) translateY(12px)} to{opacity:1;transform:scale(1) translateY(0)} }
        .food-modal-body { display:grid; grid-template-columns:1fr 1fr; min-height:340px; }
        .food-modal-img { position:relative; overflow:hidden; background:linear-gradient(135deg,#FFF3F0,#FFE0D6); display:flex; align-items:center; justify-content:center; font-size:7rem; border-radius:20px 0 0 0; }
        .food-modal-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
        .food-modal-info { padding:28px 26px; display:flex; flex-direction:column; justify-content:space-between; }
        .food-modal-close { position:absolute; top:16px; right:16px; background:white; border:none; width:34px; height:34px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.12); z-index:2; color:#555; transition:all 0.15s; }
        .food-modal-close:hover { background:#F4F6FA; color:#111; }
        .food-modal-close svg { width:18px; height:18px; }
        .food-modal-name { font-size:1.3rem; font-weight:800; color:#111; letter-spacing:-0.5px; margin-bottom:6px; }
        .food-modal-weight { font-size:0.88rem; color:#888; }
        .food-modal-price { font-size:1.6rem; font-weight:800; color:#FF5722; margin:16px 0 4px; }
        .food-modal-old-price { font-size:0.9rem; color:#B0B8C4; text-decoration:line-through; margin-bottom:20px; }
        .qty-row { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
        .qty-ctrl { display:flex; align-items:center; gap:8px; background:#F4F6FA; border-radius:12px; padding:6px 10px; }
        .qty-ctrl button { width:34px; height:34px; border:none; background:white; border-radius:9px; font-size:1.2rem; font-weight:700; cursor:pointer; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.15s; color:#555; display:flex; align-items:center; justify-content:center; }
        .qty-ctrl button:hover { background:#FF5722; color:white; }
        .qty-ctrl .qn { font-size:1rem; font-weight:700; color:#111; min-width:28px; text-align:center; }
        .btn-add-to-cart { flex:1; background:linear-gradient(135deg,#FF5722,#FF7043); color:white; border:none; padding:12px; border-radius:12px; font-family:var(--font); font-size:0.9rem; font-weight:700; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 14px rgba(255,87,34,0.3); display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-add-to-cart:hover { transform:translateY(-1px); }
        .btn-add-to-cart svg { width:18px; height:18px; }
        .food-modal-footer { padding:20px 26px; border-top:1px solid #F0F2F5; display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .food-modal-footer-label { font-size:0.72rem; font-weight:700; color:#B0B8C4; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; display:flex; align-items:center; gap:4px; }
        .food-modal-footer-label svg { width:12px; height:12px; }
        .food-modal-footer-val { font-size:0.85rem; color:#333; line-height:1.5; }
        .food-modal-nutrition { display:flex; gap:12px; flex-wrap:wrap; padding:16px 26px; border-top:1px solid #F0F2F5; }
        .nutr-item { background:#FAFBFC; border:1px solid #F0F2F5; border-radius:10px; padding:10px 14px; text-align:center; }
        .nutr-val { font-size:1rem; font-weight:800; color:#111; }
        .nutr-lbl { font-size:0.68rem; color:#888; margin-top:2px; display:flex; align-items:center; justify-content:center; gap:3px; }
        .nutr-lbl svg { width:10px; height:10px; }

        /* TOAST */
        .toast { position:fixed; bottom:28px; left:50%; transform:translateX(-50%) translateY(100px); background:#1A1D23; color:white; padding:13px 22px; border-radius:13px; display:flex; align-items:center; gap:10px; box-shadow:0 12px 40px rgba(0,0,0,0.2); z-index:9999; transition:transform 0.3s ease; font-size:0.88rem; font-weight:600; white-space:nowrap; }
        .toast.show { transform:translateX(-50%) translateY(0); }
        .toast.success { background:#1B5E20; }
        .toast.warning { background:#1A1D23; }
        .toast a { color:#FF9066; font-weight:700; }
        .toast-close { background:rgba(255,255,255,0.12); border:none; color:white; width:24px; height:24px; border-radius:6px; cursor:pointer; margin-left:4px; display:flex; align-items:center; justify-content:center; }
        .toast-close svg { width:14px; height:14px; }

        .menu-empty { text-align:center; padding:52px 20px; color:#888; }

        /* FOOTER */
        .site-footer { border-top:1px solid #EAECF0; padding:28px 40px; display:flex; align-items:center; justify-content:space-between; max-width:1280px; margin:0 auto; }
        .footer-logo { font-size:1.1rem; font-weight:800; color:#111; display:flex; align-items:center; gap:8px; }
        .footer-logo .li { width:26px; height:26px; background:linear-gradient(135deg,#FF5722,#FF7043); border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:0.8rem; }
        .footer-copy { font-size:0.8rem; color:#888; display:flex; align-items:center; gap:5px; }
        .footer-copy svg { width:13px; height:13px; }

        @media (max-width:900px) {
            .nav { padding:0 16px; }
            .hero { grid-template-columns:1fr; padding:40px 16px 32px; gap:28px; }
            .hero-visual { display:none; }
            .restaurants-section { padding:36px 16px 60px; }
            .menu-grid { grid-template-columns:repeat(auto-fill,minmax(190px,1fr)); }
            .food-modal-body { grid-template-columns:1fr; }
            .food-modal-img { height:220px; border-radius:20px 20px 0 0; }
            .trust-strip, .site-footer { padding:16px; }
            .site-footer { flex-direction:column; gap:8px; text-align:center; }
        }
        @media (max-width:500px) {
            .menu-grid { grid-template-columns:1fr 1fr; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
    <a href="/" class="nav-logo">
        <div class="logo-icon">🔥</div>
        FoodRush
    </a>
    <div class="nav-right">
        <!-- Savat — har doim ko'rinadi -->
        @auth
        <a href="{{ route('user.cart.index') }}" class="cart-nav-btn" id="cartNavBtn">
            <i data-lucide="shopping-cart" style="width:18px;height:18px;"></i>
            <span class="cart-nav-badge" id="cartNavCount" style="display:none;">0</span>
        </a>
        @endauth

        <!-- Desktop menu -->
        <div class="nav-desktop" style="display:flex; align-items:center; gap:10px;">
            @auth
                <a href="{{ route('user.orders.index') }}" class="btn-nav-ghost">
                    <i data-lucide="package" style="width:16px;height:16px;"></i>
                    Buyurtmalarim
                </a>
                <a href="{{ route('dashboard') }}" class="btn-nav-ghost">
                    <i data-lucide="layout-dashboard" style="width:16px;height:16px;"></i>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-nav-primary">
                        <i data-lucide="log-out" style="width:16px;height:16px;"></i>
                        Chiqish
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-nav-ghost">
                    <i data-lucide="log-in" style="width:16px;height:16px;"></i>
                    Kirish
                </a>
                <a href="{{ route('register') }}" class="btn-nav-primary">
                    <i data-lucide="user-plus" style="width:16px;height:16px;"></i>
                    Ro'yxatdan o'tish
                </a>
            @endauth
        </div>

        <!-- Hamburger button (mobile) -->
        <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMenu()">
            <i data-lucide="menu" style="width:20px;height:20px;"></i>
        </button>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    @auth
        <a href="{{ route('user.orders.index') }}" class="mob-item">
            <i data-lucide="package"></i> Buyurtmalarim
        </a>
        <a href="{{ route('dashboard') }}" class="mob-item">
            <i data-lucide="layout-dashboard"></i> Dashboard
        </a>
        <div class="mob-divider"></div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="mob-item danger">
                <i data-lucide="log-out"></i> Chiqish
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="mob-item">
            <i data-lucide="log-in"></i> Kirish
        </a>
        <a href="{{ route('register') }}" class="mob-item primary">
            <i data-lucide="user-plus"></i> Ro'yxatdan o'tish
        </a>
    @endauth
</div>

<!-- HERO -->
<div class="hero">
    <div>
        <div class="hero-tag">
            <span class="live-dot"></span>
            Hozir 240+ buyurtma yetkazilmoqda
        </div>
        <h1 class="hero-title">
            Sevimli ovqatingiz<br>
            <span class="highlight">30 daqiqada</span><br>
            eshigingizda
        </h1>
        <p class="hero-desc">Toshkentdagi eng yaxshi restoranlardan issiq ovqatni tez va ishonchli yetkazib beramiz.</p>
        <div class="hero-cta">
            <a href="#restaurants" class="btn-hero-p">
                <i data-lucide="utensils" style="width:18px;height:18px;"></i>
                Menyuni ko'rish
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn-hero-s">
                Ro'yxatdan o'tish
                <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
            </a>
            @endguest
        </div>
        <div class="hero-stats">
            <div><div class="h-sv">50<span>+</span></div><div class="h-sl">Restoran</div></div>
            <div class="h-sd"></div>
            <div><div class="h-sv">30<span>dk</span></div><div class="h-sl">Yetkazish</div></div>
            <div class="h-sd"></div>
            <div><div class="h-sv">4.9<span>★</span></div><div class="h-sl">Reyting</div></div>
        </div>
    </div>

    <!-- HERO VISUAL -->
    <div class="hero-visual">
        <!-- Background glow -->
        <div class="visual-glow"></div>

        <!-- Floating dots -->
        <div class="dot-decor dot-1"></div>
        <div class="dot-decor dot-2"></div>
        <div class="dot-decor dot-3"></div>

        <!-- Floating food items -->
        <div class="food-float food-float-1">🥤</div>
        <div class="food-float food-float-2">🍟</div>
        <div class="food-float food-float-3">🍕</div>
        <div class="food-float food-float-4">🍩</div>

        <!-- Chip 1 — Yetkazilmoqda (BURGER USTIDA — z-index:10) -->
        <div class="float-chip float-chip-1">
            <div class="chip-icon orange">
                <i data-lucide="bike" style="width:18px;height:18px;stroke:white;"></i>
            </div>
            <div>
                <div class="chip-title">Yetkazilmoqda</div>
                <div class="chip-sub">12 daqiqa qoldi ⚡</div>
            </div>
        </div>

        <!-- Main burger card -->
        <div class="visual-main">🍔</div>

        <!-- Chip 2 — Yetkazib berildi (BURGER USTIDA — z-index:10) -->
        <div class="float-chip float-chip-2">
            <div class="chip-icon green">
                <i data-lucide="check-circle" style="width:18px;height:18px;stroke:white;"></i>
            </div>
            <div>
                <div class="chip-title">Yetkazib berildi!</div>
                <div class="chip-sub">28 daqiqada ✅</div>
            </div>
        </div>
    </div>
</div>

<!-- TRUST -->
<div class="trust-strip">
    <span class="trust-label">
        <i data-lucide="credit-card" style="width:14px;height:14px;color:#888;"></i>
        To'lov usullari
    </span>
    <span class="trust-badge"><i data-lucide="smartphone" style="width:13px;height:13px;color:#00AAEE;"></i> Click</span>
    <span class="trust-badge"><i data-lucide="smartphone" style="width:13px;height:13px;color:#00CCAA;"></i> Payme</span>
    <span class="trust-badge"><i data-lucide="banknote" style="width:13px;height:13px;color:#2E7D32;"></i> Naqd</span>
    <span class="trust-badge"><i data-lucide="credit-card" style="width:13px;height:13px;color:#1565C0;"></i> Karta</span>
    <span class="trust-badge"><i data-lucide="shield-check" style="width:13px;height:13px;color:#FF5722;"></i> Uzcard</span>
</div>

<!-- RESTAURANTS + MENU -->
<section class="restaurants-section" id="restaurants">
    <span class="section-eyebrow">
        <i data-lucide="store" style="width:13px;height:13px;"></i>
        Restoranlar
    </span>
    <div class="section-title-main">Eng yaxshi restoranlar 🔥</div>

    @if($restaurants->isEmpty())
        <div class="menu-empty">
            <i data-lucide="utensils-crossed" style="width:48px;height:48px;color:#ccc;margin:0 auto 12px;display:block;"></i>
            <p>Hozircha restoranlar yo'q</p>
        </div>
    @else

    <div class="rest-tabs">
        @foreach($restaurants as $i => $rest)
        <button class="rest-tab {{ $i === 0 ? 'active' : '' }}" onclick="switchRest({{ $rest->id }}, this)">
            @if($rest->image)
                <img src="{{ Storage::url($rest->image) }}" class="rest-tab-img">
            @else
                <i data-lucide="store" style="width:16px;height:16px;"></i>
            @endif
            {{ $rest->name }}
        </button>
        @endforeach
    </div>

    @foreach($restaurants as $i => $rest)
    <div class="rest-panel {{ $i === 0 ? 'active' : '' }}" id="rest-{{ $rest->id }}">

        <div class="rest-info-bar">
            <div class="rest-info-left">
                <div class="rest-info-logo">
                    @if($rest->image)<img src="{{ Storage::url($rest->image) }}">@else <i data-lucide="store" style="width:22px;height:22px;color:#FF5722;"></i> @endif
                </div>
                <div>
                    <div class="rest-info-name">{{ $rest->name }}</div>
                    <div class="rest-info-meta">
                        <span><i data-lucide="clock" style="width:12px;height:12px;"></i> {{ $rest->delivery_time }} daqiqa</span>
                        <span><i data-lucide="bike" style="width:12px;height:12px;"></i> {{ number_format($rest->delivery_fee, 0) }} so'm</span>
                        @if($rest->rating > 0)<span><i data-lucide="star" style="width:12px;height:12px;color:#FFB300;"></i> {{ $rest->rating }}</span>@endif
                        <span><i data-lucide="utensils" style="width:12px;height:12px;"></i> {{ $rest->foods_count }} taom</span>
                    </div>
                </div>
            </div>
            <span class="rest-open-badge {{ $rest->is_open ? 'open' : 'closed' }}">
                @if($rest->is_open)
                    <i data-lucide="circle-dot" style="width:11px;height:11px;"></i> Ochiq
                @else
                    <i data-lucide="circle-off" style="width:11px;height:11px;"></i> Yopiq
                @endif
            </span>
        </div>

        @php $cats = $rest->categories->filter(fn($c) => $c->foods->count() > 0); @endphp
        @if($cats->count() > 0)
        <div class="cat-filter" id="cf-{{ $rest->id }}">
            <button class="cat-btn active" onclick="filterCat('all',this,{{ $rest->id }})">
                <i data-lucide="layout-grid" style="width:13px;height:13px;"></i> Barchasi
            </button>
            @foreach($cats as $cat)
            <button class="cat-btn" onclick="filterCat({{ $cat->id }},this,{{ $rest->id }})">{{ $cat->name }}</button>
            @endforeach
        </div>
        @endif

        @php $foods = $rest->categories->flatMap(fn($c) => $c->foods); @endphp
        @if($foods->isEmpty())
            <div class="menu-empty">
                <i data-lucide="package-open" style="width:40px;height:40px;color:#ddd;margin:0 auto 12px;display:block;"></i>
                <p>Bu restoranda hozircha taomlar yo'q</p>
            </div>
        @else
        <div class="menu-grid" id="mg-{{ $rest->id }}">
            @foreach($foods as $food)
            <div class="menu-card" data-cat="{{ $food->category_id }}"
                 onclick="openFoodModal({{ $food->id }}, '{{ addslashes($food->name) }}', '{{ $food->image ? Storage::url($food->image) : '' }}', {{ $food->discount_price ?? $food->price }}, {{ $food->price }}, '{{ addslashes($food->description ?? '') }}', '{{ addslashes($food->ingredients ?? '') }}', {{ $food->calories ?? 'null' }}, {{ $food->prep_time ?? 'null' }}, {{ $food->is_popular ? 'true' : 'false' }})">
                <div class="menu-card-img">
                    @if($food->image)<img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}">@else 🍽️ @endif
                    @if($food->is_popular)
                        <span class="menu-popular">
                            <i data-lucide="flame" style="width:10px;height:10px;stroke:white;"></i> Popular
                        </span>
                    @endif
                </div>
                <div class="menu-card-body">
                    <div class="menu-card-name">{{ $food->name }}</div>
                    @if($food->description)<div class="menu-card-desc">{{ $food->description }}</div>@endif
                    <div class="menu-card-footer">
                        <div class="menu-card-price">
                            {{ number_format($food->discount_price ?? $food->price, 0, '.', ' ') }} so'm
                            @if($food->discount_price)<span class="old">{{ number_format($food->price, 0, '.', ' ') }}</span>@endif
                        </div>
                        @if($food->prep_time)
                        <div class="menu-card-meta">
                            <i data-lucide="clock" style="width:11px;height:11px;"></i>{{ $food->prep_time }}m
                        </div>
                        @endif
                    </div>
                    <button class="btn-open-modal" onclick="event.stopPropagation(); openFoodModal({{ $food->id }}, '{{ addslashes($food->name) }}', '{{ $food->image ? Storage::url($food->image) : '' }}', {{ $food->discount_price ?? $food->price }}, {{ $food->price }}, '{{ addslashes($food->description ?? '') }}', '{{ addslashes($food->ingredients ?? '') }}', {{ $food->calories ?? 'null' }}, {{ $food->prep_time ?? 'null' }}, {{ $food->is_popular ? 'true' : 'false' }})">
                        <i data-lucide="shopping-cart" style="width:16px;height:16px;stroke:white;"></i>
                        Buyurtma berish
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
    @endif
</section>

<!-- FOOTER -->
<footer>
    <div class="site-footer">
        <div class="footer-logo"><div class="li">🔥</div> FoodRush</div>
        <div class="footer-copy">
            <i data-lucide="copyright" style="width:13px;height:13px;"></i>
            {{ date('Y') }} FoodRush. Barcha huquqlar himoyalangan.
        </div>
    </div>
</footer>

<!-- FOOD DETAIL MODAL -->
<div class="food-modal-backdrop" id="foodModal">
    <div class="food-modal" style="position:relative;">
        <button class="food-modal-close" onclick="closeFoodModal()">
            <i data-lucide="x"></i>
        </button>
        <div class="food-modal-body">
            <div class="food-modal-img" id="modalImg">🍽️</div>
            <div class="food-modal-info">
                <div>
                    <div class="food-modal-name" id="modalName">—</div>
                    <div class="food-modal-weight" id="modalWeight"></div>
                    <div class="food-modal-price" id="modalPrice">—</div>
                    <div class="food-modal-old-price" id="modalOldPrice" style="display:none;"></div>
                </div>
                <div>
                    <div class="qty-row">
                        <div class="qty-ctrl">
                            <button onclick="changeQty(-1)">−</button>
                            <span class="qn" id="modalQty">1</span>
                            <button onclick="changeQty(1)">+</button>
                        </div>
                        <button class="btn-add-to-cart" onclick="addToCart()">
                            <i data-lucide="shopping-bag" style="width:18px;height:18px;stroke:white;"></i>
                            Savatga
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="food-modal-footer" id="modalFooter" style="display:none;">
            <div>
                <div class="food-modal-footer-label">
                    <i data-lucide="file-text" style="width:12px;height:12px;"></i> Tavsif
                </div>
                <div class="food-modal-footer-val" id="modalDesc"></div>
            </div>
            <div>
                <div class="food-modal-footer-label">
                    <i data-lucide="leaf" style="width:12px;height:12px;"></i> Ingredientlar
                </div>
                <div class="food-modal-footer-val" id="modalIng"></div>
            </div>
        </div>
        <div class="food-modal-nutrition" id="modalNutr" style="display:none;">
            <div class="nutr-item" id="nutrCal">
                <div class="nutr-val"></div>
                <div class="nutr-lbl"><i data-lucide="flame" style="width:10px;height:10px;"></i> kkal</div>
            </div>
            <div class="nutr-item" id="nutrTime">
                <div class="nutr-val"></div>
                <div class="nutr-lbl"><i data-lucide="clock" style="width:10px;height:10px;"></i> daqiqa</div>
            </div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast">
    <span id="toastMsg"></span>
    <button class="toast-close" onclick="hideToast()">
        <i data-lucide="x" style="width:14px;height:14px;"></i>
    </button>
</div>

<script>
// Init Lucide icons
lucide.createIcons();

// Hamburger menu
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('hamburgerBtn');
    menu.classList.toggle('open');
    // Icon o'zgarish
    const isOpen = menu.classList.contains('open');
    btn.innerHTML = isOpen
        ? '<i data-lucide="x" style="width:20px;height:20px;"></i>'
        : '<i data-lucide="menu" style="width:20px;height:20px;"></i>';
    lucide.createIcons();
}

// Tashqarini bossa menu yopilsin
document.addEventListener('click', function(e) {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('hamburgerBtn');
    if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove('open');
        btn.innerHTML = '<i data-lucide="menu" style="width:20px;height:20px;"></i>';
        lucide.createIcons();
    }
});

let currentFoodId = null;
let currentQty = 1;
let toastTimer;
const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

function switchRest(id, el) {
    document.querySelectorAll('.rest-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.rest-panel').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('rest-' + id).classList.add('active');
}

function filterCat(catId, el, restId) {
    document.getElementById('cf-' + restId)?.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('mg-' + restId)?.querySelectorAll('.menu-card').forEach(c => {
        c.style.display = (catId === 'all' || c.dataset.cat == catId) ? '' : 'none';
    });
}

function openFoodModal(id, name, img, price, oldPrice, desc, ing, cal, prepTime, popular) {
    currentFoodId = id;
    currentQty = 1;
    document.getElementById('modalQty').textContent = 1;
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalPrice').textContent = formatPrice(price) + ' so\'m';
    const imgEl = document.getElementById('modalImg');
    imgEl.innerHTML = img ? `<img src="${img}" alt="${name}">` : '🍽️';
    const oldEl = document.getElementById('modalOldPrice');
    if (oldPrice && oldPrice !== price) {
        oldEl.textContent = formatPrice(oldPrice) + ' so\'m';
        oldEl.style.display = 'block';
    } else { oldEl.style.display = 'none'; }
    const footer = document.getElementById('modalFooter');
    if (desc || ing) {
        footer.style.display = 'grid';
        document.getElementById('modalDesc').textContent = desc || '—';
        document.getElementById('modalIng').textContent = ing || '—';
    } else { footer.style.display = 'none'; }
    const nutr = document.getElementById('modalNutr');
    if (cal || prepTime) {
        nutr.style.display = 'flex';
        if (cal) { document.querySelector('#nutrCal .nutr-val').textContent = cal; document.getElementById('nutrCal').style.display='block'; } else { document.getElementById('nutrCal').style.display='none'; }
        if (prepTime) { document.querySelector('#nutrTime .nutr-val').textContent = prepTime; document.getElementById('nutrTime').style.display='block'; } else { document.getElementById('nutrTime').style.display='none'; }
    } else { nutr.style.display = 'none'; }
    document.getElementById('foodModal').classList.add('open');
    document.body.style.overflow = 'hidden';
    lucide.createIcons();
}

function closeFoodModal() {
    document.getElementById('foodModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('foodModal').addEventListener('click', function(e) { if (e.target === this) closeFoodModal(); });

function changeQty(delta) {
    currentQty = Math.max(1, Math.min(20, currentQty + delta));
    document.getElementById('modalQty').textContent = currentQty;
}

function addToCart() {
    if (!isLoggedIn) {
        closeFoodModal();
        showToast('⚠️ Buyurtma berish uchun <a href="{{ route("login") }}">kiring</a> yoki <a href="{{ route("register") }}">ro\'yxatdan o\'ting</a>', 'warning');
        return;
    }
    fetch('{{ route("user.cart.add") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ food_id: currentFoodId, quantity: currentQty })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            closeFoodModal();
            updateCartBadge(data.count);
            showToast('✅ Savatga qo\'shildi!', 'success');
        } else {
            showToast('⚠️ ' + data.message, 'warning');
        }
    });
}

function updateCartBadge(count) {
    const badge = document.getElementById('cartNavCount');
    if (!badge) return;
    if (count > 0) { badge.textContent = count; badge.style.display = 'flex'; }
    else { badge.style.display = 'none'; }
}

@auth
fetch('{{ route("user.cart.count") }}').then(r => r.json()).then(d => updateCartBadge(d.count));
@endauth

let toastTimerRef;
function showToast(msg, type = 'warning') {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').innerHTML = msg;
    t.className = 'toast ' + type + ' show';
    clearTimeout(toastTimerRef);
    toastTimerRef = setTimeout(hideToast, 4000);
}
function hideToast() { document.getElementById('toast').classList.remove('show'); }
function formatPrice(n) { return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' '); }

document.querySelector('a[href="#restaurants"]')?.addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('restaurants').scrollIntoView({ behavior: 'smooth' });
});
</script>
</body>
</html>