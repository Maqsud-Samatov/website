@extends('delivery.layout')
@section('title', 'Tarix')

@section('content')

<div class="d-nav">
    <div class="d-nav-left">
        <div class="d-nav-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="d-nav-name">Yetkazish tarixi</div>
            <div class="d-nav-role">🛵 Kuryer</div>
        </div>
    </div>
</div>

<div class="d-page-content" style="padding-top:12px;">
    <div class="d-section">
        <div class="d-section-title">
            <i data-lucide="history" style="width:13px;height:13px;"></i>
            BARCHA YETKAZILGAN BUYURTMALAR
        </div>

        @forelse($orders as $order)
        <div class="d-order-card">
            <div class="d-order-header">
                <div>
                    <div class="d-order-id">#{{ $order->id }}</div>
                    <div class="d-order-time">
                        <i data-lucide="clock" style="width:11px;height:11px;"></i>
                        {{ $order->delivered_at?->format('d.m.Y H:i') }}
                    </div>
                </div>
                <span class="d-status delivered">
                    <i data-lucide="check-circle" style="width:11px;height:11px;"></i>
                    Yetkazildi
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
                    </div>
                </div>
                <div class="d-info-row">
                    <div class="d-info-icon red">
                        <i data-lucide="map-pin" style="width:16px;height:16px;"></i>
                    </div>
                    <div>
                        <div class="d-info-label">MANZIL</div>
                        <div class="d-info-value">{{ $order->address }}</div>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:8px; border-top:1px solid #F0F2F5;">
                    <span style="font-size:0.8rem; color:#888;">Yetkazish narxi</span>
                    <span style="font-weight:800; color:#FF5722;">{{ number_format($order->delivery_fee, 0, '.', ' ') }} so'm</span>
                </div>
            </div>
        </div>
        @empty
        <div class="d-empty">
            <i data-lucide="package-open"></i>
            <h3>Tarix bo'sh</h3>
            <p style="font-size:0.85rem;">Hali hech qanday buyurtma yetkazilmagan</p>
        </div>
        @endforelse

        {{ $orders->links() }}
    </div>
</div>
@endsection