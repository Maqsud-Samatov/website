@extends('admin.layout')
@section('title', 'Buyurtmalar')
@section('page-title', 'Buyurtmalar')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-title">📦 Buyurtmalar</div>
        <div class="page-header-sub">Jami {{ $orders->total() }} ta buyurtma</div>
    </div>
</div>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Mijoz</th>
                    <th>Restoran</th>
                    <th>Summa</th>
                    <th>To'lov</th>
                    <th>Status</th>
                    <th>Vaqt</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong style="color:#FF5722;">#{{ $order->id }}</strong></td>
                    <td>
                        <div style="font-weight:700; font-size:0.88rem;">{{ $order->user->name ?? '—' }}</div>
                        <div style="font-size:0.75rem; color:#888;">{{ $order->phone }}</div>
                    </td>
                    <td style="font-size:0.88rem;">{{ $order->restaurant->name ?? '—' }}</td>
                    <td>
                        <div style="font-weight:700; font-size:0.88rem;">{{ number_format($order->total, 0, '.', ' ') }} so'm</div>
                        @if($order->commission > 0)
                            <div style="font-size:0.72rem; color:#2E7D32;">+{{ number_format($order->commission, 0, '.', ' ') }} komissiya</div>
                        @endif
                    </td>
                    <td>
                        <span class="admin-badge {{ $order->payment_method === 'cash' ? 'gray' : 'blue' }}">
                            {{ match($order->payment_method) {
                                'click' => '💳 Click',
                                'payme' => '💳 Payme',
                                default => '💵 Naqd'
                            } }}
                        </span>
                        <div style="margin-top:4px;">
                            <span class="admin-badge {{ $order->payment_status === 'paid' ? 'green' : 'orange' }}" style="font-size:0.65rem;">
                                {{ $order->payment_status === 'paid' ? '✅ To\'langan' : '⏳ To\'lanmagan' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        @php $s = $order->status_label; @endphp
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                            @csrf
                            <select name="status" onchange="this.form.submit()"
                                style="padding:5px 10px; border:1.5px solid #E5E7EB; border-radius:8px; font-family:var(--font); font-size:0.78rem; cursor:pointer; background:white;">
                                <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>⏳ Kutilmoqda</option>
                                <option value="confirmed"  {{ $order->status === 'confirmed'  ? 'selected' : '' }}>✅ Tasdiqlandi</option>
                                <option value="preparing"  {{ $order->status === 'preparing'  ? 'selected' : '' }}>👨‍🍳 Tayyorlanmoqda</option>
                                <option value="on_the_way" {{ $order->status === 'on_the_way' ? 'selected' : '' }}>🛵 Yo'lda</option>
                                <option value="delivered"  {{ $order->status === 'delivered'  ? 'selected' : '' }}>🏠 Yetkazildi</option>
                                <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>❌ Bekor</option>
                            </select>
                        </form>
                    </td>
                    <td style="color:#888; font-size:0.78rem; white-space:nowrap;">
                        {{ $order->created_at->format('d.m.Y') }}<br>
                        {{ $order->created_at->format('H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                            👁️ Ko'rish
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:48px; color:#888;">
                        <div style="font-size:2.5rem; margin-bottom:10px;">📦</div>
                        Buyurtmalar yo'q
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div style="padding:16px 22px; border-top:1px solid #F0F2F5;">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection