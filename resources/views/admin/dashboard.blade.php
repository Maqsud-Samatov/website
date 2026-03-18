@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-actions')
    <a href="{{ route('admin.restaurants.create') }}" class="admin-btn admin-btn-primary admin-btn-lg">
        + Restoran qo'shish
    </a>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-title">Salom, {{ auth()->user()->name }}! 👋</div>
        <div class="page-header-sub">{{ now()->format('d-M Y, H:i') }} — FoodRush Admin Panel</div>
    </div>
</div>

<!-- STATS -->
<div class="admin-stats">
    <div class="admin-stat-card orange">
        <div class="admin-stat-top">
            <div class="admin-stat-icon orange">🍽️</div>
            <div class="admin-stat-trend up">↑ Faol</div>
        </div>
        <div class="admin-stat-value">{{ $stats['restaurants'] }}</div>
        <div class="admin-stat-label">Jami restoranlar</div>
    </div>
    <div class="admin-stat-card blue">
        <div class="admin-stat-top">
            <div class="admin-stat-icon blue">👥</div>
            <div class="admin-stat-trend up">↑ Yangi</div>
        </div>
        <div class="admin-stat-value">{{ $stats['users'] }}</div>
        <div class="admin-stat-label">Foydalanuvchilar</div>
    </div>
    <div class="admin-stat-card green">
        <div class="admin-stat-top">
            <div class="admin-stat-icon green">📦</div>
            @if($stats['pending'] > 0)
                <div class="admin-stat-trend down">{{ $stats['pending'] }} kutmoqda</div>
            @else
                <div class="admin-stat-trend up">↑ Yaxshi</div>
            @endif
        </div>
        <div class="admin-stat-value">{{ $stats['orders'] }}</div>
        <div class="admin-stat-label">Jami buyurtmalar</div>
    </div>
    <div class="admin-stat-card purple">
        <div class="admin-stat-top">
            <div class="admin-stat-icon purple">💰</div>
            <div class="admin-stat-trend up">↑ Daromad</div>
        </div>
        <div class="admin-stat-value">{{ number_format($stats['revenue'] / 1000, 0) }}K</div>
        <div class="admin-stat-label">Jami daromad (so'm)</div>
    </div>
</div>

<!-- MAIN GRID -->
<div class="admin-main-grid">

    <!-- RECENT ORDERS -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title">
                📦 So'nggi buyurtmalar
            </div>
            <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                Barchasi →
            </a>
        </div>
        <div class="admin-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mijoz</th>
                        <th>Restoran</th>
                        <th>Summa</th>
                        <th>Status</th>
                        <th>Vaqt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong style="color:#FF5722;">#{{ $order->id }}</strong></td>
                        <td>
                            <div class="td-name">{{ $order->user->name ?? '—' }}</div>
                        </td>
                        <td>{{ $order->restaurant->name ?? '—' }}</td>
                        <td>
                            <strong>{{ number_format($order->total, 0, '.', ' ') }} so'm</strong>
                        </td>
                        <td>
                            @php $s = $order->status_label; @endphp
                            <span class="admin-badge {{ $s['color'] }}">{{ $s['label'] }}</span>
                        </td>
                        <td style="color:#8A92A0; font-size:0.78rem;">
                            {{ $order->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:48px; color:#8A92A0;">
                            <div style="font-size:2.5rem; margin-bottom:10px;">📦</div>
                            Buyurtmalar yo'q
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div style="display:flex; flex-direction:column; gap:20px;">

        <!-- RECENT USERS -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">👥 Yangi a'zolar</div>
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Barchasi →</a>
            </div>
            <div class="admin-card-body">
                @forelse($recentUsers as $user)
                <div class="user-list-item">
                    <div class="user-list-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div class="user-list-name">{{ $user->name }}</div>
                        <div class="user-list-email">{{ $user->email }}</div>
                    </div>
                    <span class="admin-badge {{ $user->role === 'admin' ? 'purple' : ($user->role === 'owner' ? 'blue' : ($user->role === 'delivery' ? 'orange' : 'gray')) }}">
                        {{ $user->role }}
                    </span>
                </div>
                @empty
                <div style="text-align:center; padding:32px; color:#8A92A0;">
                    Foydalanuvchilar yo'q
                </div>
                @endforelse
            </div>
        </div>

        <!-- QUICK STATS -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">📊 Tezkor statistika</div>
            </div>
            <div class="admin-card-body-pad">
                <div style="display:flex; flex-direction:column; gap:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:#FAFBFC; border-radius:10px; border:1px solid #F0F2F5;">
                        <span style="font-size:0.85rem; font-weight:600; color:#333;">🍽️ Taomlar</span>
                        <strong style="color:#FF5722;">{{ $stats['foods'] }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:#FAFBFC; border-radius:10px; border:1px solid #F0F2F5;">
                        <span style="font-size:0.85rem; font-weight:600; color:#333;">⏳ Kutilmoqda</span>
                        <span class="admin-badge {{ $stats['pending'] > 0 ? 'orange' : 'green' }}">{{ $stats['pending'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:#FAFBFC; border-radius:10px; border:1px solid #F0F2F5;">
                        <span style="font-size:0.85rem; font-weight:600; color:#333;">✅ Yetkazildi</span>
                        <span class="admin-badge green">{{ \App\Models\Order::where('status','delivered')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection