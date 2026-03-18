@extends('owner.layout')
@section('title', 'Dashboard')
@section('page-title', '📊 Dashboard')

@section('content')

@if(!$restaurant)
    <div style="text-align:center; padding:80px 20px;">
        <div style="font-size:4rem; margin-bottom:16px;">🍽️</div>
        <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:10px;">Restoraningiz hali yo'q</h2>
        <p style="color:var(--muted); margin-bottom:24px;">Admin tomonidan restoraningiz qo'shilishini kuting yoki admindan so'rang.</p>
    </div>
@else

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF3F0;">🍽️</div>
        <div><div class="stat-val">{{ $stats['foods'] }}</div><div class="stat-lbl">Taomlar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#E3F2FD;">📦</div>
        <div><div class="stat-val">{{ $stats['orders'] }}</div><div class="stat-lbl">Buyurtmalar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF8E1;">⏳</div>
        <div><div class="stat-val">{{ $stats['pending'] }}</div><div class="stat-lbl">Kutilmoqda</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#E8F5E9;">💰</div>
        <div><div class="stat-val">{{ number_format($stats['revenue'], 0, '.', ' ') }}</div><div class="stat-lbl">Daromad (so'm)</div></div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">📦 So'nggi buyurtmalar</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>Mijoz</th><th>Summa</th><th>Status</th><th>Vaqt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? '—' }}</td>
                        <td><strong>{{ number_format($order->total, 0, '.', ' ') }} so'm</strong></td>
                        <td>
                            @php $s = $order->status_label; @endphp
                            <span class="badge badge-{{ $s['color'] }}">{{ $s['label'] }}</span>
                        </td>
                        <td style="color:var(--muted); font-size:0.78rem;">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center; padding:40px; color:var(--muted);">Buyurtmalar yo'q</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">🏪 Restoran info</div>
        </div>
        <div class="card-body">
            <div style="display:flex; flex-direction:column; gap:14px;">
                <div style="display:flex; justify-content:space-between; font-size:0.88rem;">
                    <span style="color:var(--muted);">Nomi</span>
                    <strong>{{ $restaurant->name }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.88rem;">
                    <span style="color:var(--muted);">Holat</span>
                    @if($restaurant->is_active)
                        <span class="badge badge-green">✅ Faol</span>
                    @else
                        <span class="badge badge-red">❌ Nofaol</span>
                    @endif
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.88rem;">
                    <span style="color:var(--muted);">Yetkazish</span>
                    <strong>{{ $restaurant->delivery_time }} daqiqa</strong>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.88rem;">
                    <span style="color:var(--muted);">Yetkazish narxi</span>
                    <strong>{{ number_format($restaurant->delivery_fee, 0) }} so'm</strong>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.88rem;">
                    <span style="color:var(--muted);">Reyting</span>
                    <strong style="color:#FFB300;">★ {{ $restaurant->rating ?: '—' }}</strong>
                </div>
            </div>
            <div style="margin-top:20px;">
                <a href="{{ route('owner.menu.index') }}" class="btn btn-primary" style="width:100%; justify-content:center;">🍽️ Menyuni boshqarish</a>
            </div>
        </div>
    </div>
</div>

@endif
@endsection