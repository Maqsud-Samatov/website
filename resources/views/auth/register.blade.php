<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro'yxatdan o'tish — FoodRush</title>
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
            <h2 class="auth-left-title">Kim siz?<br><span>Rolingizni</span> tanlang</h2>
            <p class="auth-left-desc">FoodRush da 4 xil rol mavjud. O'zingizga mosini tanlang.</p>

            <div class="role-preview">
                <div class="role-preview-item">
                    <span class="rp-icon">👤</span>
                    <div class="rp-info">
                        <div class="rp-name">Mijoz (User)</div>
                        <div class="rp-desc">Ovqat buyurtma berish</div>
                    </div>
                </div>
                <div class="role-preview-item">
                    <span class="rp-icon">🍽️</span>
                    <div class="rp-info">
                        <div class="rp-name">Restoran egasi</div>
                        <div class="rp-desc">Menyu va buyurtmalarni boshqarish</div>
                    </div>
                </div>
                <div class="role-preview-item">
                    <span class="rp-icon">🛵</span>
                    <div class="rp-info">
                        <div class="rp-name">Yetkazuvchi</div>
                        <div class="rp-desc">Buyurtmalarni yetkazib berish</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-left-footer">© {{ date('Y') }} FoodRush</div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <h1 class="auth-title">Ro'yxatdan o'tish</h1>
        <p class="auth-subtitle">Hisobingiz bormi? <a href="{{ route('login') }}">Kirish</a></p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- ROLE SELECTOR -->
            <div style="margin-bottom:22px;">
                <label class="field-label">Rolingizni tanlang *</label>
                <div class="role-selector">

                    <div>
                        <input type="radio" name="role" id="role_user" value="user" class="role-option"
                            {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                        <label for="role_user" class="role-label">
                            <span class="role-emoji">👤</span>
                            <span class="role-name">Mijoz</span>
                            <span class="role-desc-text">Ovqat buyurtma beraman</span>
                        </label>
                    </div>

                    <div>
                        <input type="radio" name="role" id="role_owner" value="owner" class="role-option"
                            {{ old('role') === 'owner' ? 'checked' : '' }}>
                        <label for="role_owner" class="role-label">
                            <span class="role-emoji">🍽️</span>
                            <span class="role-name">Restoran egasi</span>
                            <span class="role-desc-text">Restoranim bor</span>
                        </label>
                    </div>

                    <div>
                        <input type="radio" name="role" id="role_delivery" value="delivery" class="role-option"
                            {{ old('role') === 'delivery' ? 'checked' : '' }}>
                        <label for="role_delivery" class="role-label">
                            <span class="role-emoji">🛵</span>
                            <span class="role-name">Yetkazuvchi</span>
                            <span class="role-desc-text">Buyurtma yetkazaman</span>
                        </label>
                    </div>

                    <div>
                        <input type="radio" name="role" id="role_admin" value="admin" class="role-option"
                            {{ old('role') === 'admin' ? 'checked' : '' }}>
                        <label for="role_admin" class="role-label">
                            <span class="role-emoji">👑</span>
                            <span class="role-name">Admin</span>
                            <span class="role-desc-text">Tizimni boshqaraman</span>
                        </label>
                    </div>

                </div>
                @error('role') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
            </div>

            <!-- NAME -->
            <div class="form-group">
                <label class="field-label">Ism familiya *</label>
                <div class="input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Isim Familiya" required autofocus>
                </div>
                @error('name') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label class="field-label">Email manzil *</label>
                <div class="input-wrap">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@example.com" required>
                </div>
                @error('email') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-row-2">
                <div class="form-group">
                    <label class="field-label">Parol *</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input type="password" name="password" placeholder="Min. 8 belgi" required>
                    </div>
                    @error('password') <div class="error-msg">⚠️ {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="field-label">Parolni tasdiqlang *</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input type="password" name="password_confirmation" placeholder="Qayta kiriting" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                ✅ Ro'yxatdan o'tish
            </button>

            <p class="terms">Ro'yxatdan o'tish orqali <a href="#">Foydalanish shartlari</a> ga rozililik bildirasiz.</p>
        </form>
    </div>
</div>

</body>
</html>