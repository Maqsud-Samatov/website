<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish — FoodRush</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">

<div class="auth-wrapper">
    <!-- LEFT -->
    <div class="auth-left">
        <a href="{{ url('/') }}" class="auth-logo">
            <div class="logo-icon">🔥</div>
            <div class="logo-text">FoodRush</div>
        </a>

        <div class="auth-left-content">
            <h2 class="auth-left-title">Xush kelibsiz<br><span>FoodRush</span> ga!</h2>
            <p class="auth-left-desc">Sevimli ovqatingizni 30 daqiqada eshigingizga yetkazib beramiz.</p>

            <div class="auth-features">
                <div class="auth-feature">
                    <div class="feat-icon">⚡</div>
                    30 daqiqada yetkazib berish
                </div>
                <div class="auth-feature">
                    <div class="feat-icon">🍽️</div>
                    50+ restoran, 500+ taom
                </div>
                <div class="auth-feature">
                    <div class="feat-icon">💳</div>
                    Click, Payme, naqd to'lov
                </div>
                <div class="auth-feature">
                    <div class="feat-icon">📍</div>
                    Real vaqt kuzatuvi
                </div>
            </div>
        </div>

        <div class="auth-left-footer">© {{ date('Y') }} FoodRush</div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <h1 class="auth-title">Kirish</h1>
        <p class="auth-subtitle">Hisobingiz yo'qmi? <a href="{{ route('register') }}">Ro'yxatdan o'ting</a></p>

        @if ($errors->any())
            <div class="alert-error">❌ Email yoki parol noto'g'ri</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email manzil</label>
                <div class="input-wrap">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@example.com"
                        class="{{ $errors->has('email') ? 'error' : '' }}" required autofocus>
                </div>
                @error('email') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Parol</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                        placeholder="Parolni kiriting"
                        class="{{ $errors->has('password') ? 'error' : '' }}" required>
                </div>
                @error('password') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <label class="remember">
                    <input type="checkbox" name="remember"> Eslab qolish
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot">Parolni unutdingizmi?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                🚀 Kirish
            </button>
        </form>
    </div>
</div>

</body>
</html>