@extends('delivery.layout')
@section('title', 'Kuryer Dashboard')

@section('content')

<!-- TOP NAV -->
<div class="d-nav">
    <div class="d-nav-left">
        <div class="d-nav-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="d-nav-name">{{ auth()->user()->name }}</div>
            <div class="d-nav-role">🛵 Kuryer</div>
        </div>
    </div>
    <div class="d-nav-right">
        <button class="d-nav-btn" onclick="location.reload()">
            <i data-lucide="refresh-cw" style="width:18px;height:18px;"></i>
        </button>
    </div>
</div>

<div class="d-page-content">

    @if(session('success'))
        <div class="d-alert d-alert-success" style="margin-top:12px;">
            <i data-lucide="check-circle" style="width:16px;height:16px;"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="d-alert d-alert-error" style="margin-top:12px;">
            <i data-lucide="alert-circle" style="width:16px;height:16px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- STATS -->
    <div class="d-stats">
        <div class="d-stat">
            <div class="d-stat-val">{{ $completedToday }}<span></span></div>
            <div class="d-stat-lbl">
                <i data-lucide="check-circle" style="width:11px;height:11px;"></i>
                Bugun yetkazildi
            </div>
        </div>
        <div class="d-stat">
            <div class="d-stat-val">{{ number_format($earningsToday / 1000, 0) }}<span>K</span></div>
            <div class="d-stat-lbl">
                <i data-lucide="banknote" style="width:11px;height:11px;"></i>
                Bugungi daromad
            </div>
        </div>
    </div>

    <!-- MENING BUYURTMALARIM -->
    @if($myOrders->count() > 0)
    <div class="d-section">
        <div class="d-section-title">
            <i data-lucide="bike" style="width:13px;height:13px;"></i>
            MENING BUYURTMALARIM ({{ $myOrders->count() }})
        </div>

        @foreach($myOrders as $order)
        <div class="d-order-card">
            <div class="d-order-header">
                <div>
                    <div class="d-order-id">#{{ $order->id }}</div>
                    <div class="d-order-time">
                        <i data-lucide="clock" style="width:11px;height:11px;"></i>
                        {{ $order->created_at->diffForHumans() }}
                    </div>
                </div>
                <span class="d-status on-way">
                    <i data-lucide="navigation" style="width:11px;height:11px;"></i>
                    Yo'lda
                </span>
            </div>

            <div class="d-order-body">
                <!-- Restoran -->
                <div class="d-info-row">
                    <div class="d-info-icon orange">
                        <i data-lucide="store" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">RESTORAN</div>
                        <div class="d-info-value">{{ $order->restaurant->name }}</div>
                        <div style="font-size:0.75rem; color:#888;">{{ $order->restaurant->address }}</div>
                    </div>
                </div>

                <!-- Mijoz -->
                <div class="d-info-row">
                    <div class="d-info-icon blue">
                        <i data-lucide="user" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">MIJOZ</div>
                        <div class="d-info-value">{{ $order->user->name }}</div>
                    </div>
                </div>

                <!-- Telefon -->
                <div class="d-info-row">
                    <div class="d-info-icon green">
                        <i data-lucide="phone" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">TELEFON</div>
                        <div class="d-info-value">
                            <a href="tel:{{ $order->phone }}" style="color:#1565C0; text-decoration:none;">
                                {{ $order->phone }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Manzil -->
                <div class="d-info-row">
                    <div class="d-info-icon red">
                        <i data-lucide="map-pin" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">MANZIL</div>
                        <div class="d-info-value">{{ $order->address }}</div>
                    </div>
                </div>

                <!-- Buyurtma tarkibi -->
                <div class="d-order-items">
                    @foreach($order->items as $item)
                    <div class="d-order-item">
                        <span class="d-order-item-name">{{ $item->food->name }} × {{ $item->quantity }}</span>
                        <span class="d-order-item-price">{{ number_format($item->total, 0, '.', ' ') }} so'm</span>
                    </div>
                    @endforeach
                    <div class="d-order-total">
                        <span>Jami:</span>
                        <span style="color:#FF5722;">{{ number_format($order->total, 0, '.', ' ') }} so'm</span>
                    </div>
                </div>

                @if($order->note)
                <div style="background:#FFFDE7; border-radius:10px; padding:10px 12px; margin-bottom:12px; font-size:0.82rem; color:#F57F17;">
                    <i data-lucide="message-square" style="width:13px;height:13px;"></i>
                    {{ $order->note }}
                </div>
                @endif

                <!-- Tugmalar -->
                @if(!$order->picked_up_at)
                <form method="POST" action="{{ route('delivery.pickup', $order) }}">
                    @csrf
                    <button type="submit" class="d-btn d-btn-pickup">
                        <i data-lucide="package-check" style="width:18px;height:18px;"></i>
                        Zakasni oldim — Yo'lga chiqdim
                    </button>
                </form>
                @else
                <form method="POST" action="{{ route('delivery.deliver', $order) }}">
                    @csrf
                    <button type="submit" class="d-btn d-btn-deliver">
                        <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
                        Yetkazib berdim ✅
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- YANGI BUYURTMALAR -->
    <div class="d-section">
        <div class="d-section-title">
            <i data-lucide="bell" style="width:13px;height:13px;"></i>
            YANGI BUYURTMALAR ({{ $newOrders->count() }})
        </div>

        @forelse($newOrders as $order)
        <div class="d-order-card">
            <div class="d-order-header">
                <div>
                    <div class="d-order-id">#{{ $order->id }}</div>
                    <div class="d-order-time">
                        <i data-lucide="clock" style="width:11px;height:11px;"></i>
                        {{ $order->created_at->diffForHumans() }}
                    </div>
                </div>
                <span class="d-status new">
                    <i data-lucide="zap" style="width:11px;height:11px;"></i>
                    Yangi
                </span>
            </div>

            <div class="d-order-body">
                <div class="d-info-row">
                    <div class="d-info-icon orange">
                        <i data-lucide="store" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">RESTORAN</div>
                        <div class="d-info-value">{{ $order->restaurant->name }}</div>
                        <div style="font-size:0.75rem; color:#888;">{{ $order->restaurant->address }}</div>
                    </div>
                </div>

                <div class="d-info-row">
                    <div class="d-info-icon red">
                        <i data-lucide="map-pin" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">YETKAZISH MANZILI</div>
                        <div class="d-info-value">{{ $order->address }}</div>
                    </div>
                </div>

                <div class="d-order-items">
                    @foreach($order->items as $item)
                    <div class="d-order-item">
                        <span class="d-order-item-name">{{ $item->food->name }} × {{ $item->quantity }}</span>
                        <span class="d-order-item-price">{{ number_format($item->total, 0, '.', ' ') }} so'm</span>
                    </div>
                    @endforeach
                    <div class="d-order-total">
                        <span>Jami:</span>
                        <span style="color:#FF5722;">{{ number_format($order->total, 0, '.', ' ') }} so'm</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('delivery.accept', $order) }}">
                    @csrf
                    <button type="submit" class="d-btn d-btn-accept">
                        <i data-lucide="hand" style="width:18px;height:18px;"></i>
                        Qabul qilish
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="d-empty">
            <i data-lucide="package-open"></i>
            <h3>Yangi buyurtmalar yo'q</h3>
            <p style="font-size:0.85rem;">Hozircha yetkazish uchun buyurtma yo'q</p>
        </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
// Auto-refresh har 30 soniyada
setTimeout(() => location.reload(), 30000);
</script>
@endpush

@endsection