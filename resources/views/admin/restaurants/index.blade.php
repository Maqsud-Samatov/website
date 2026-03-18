@extends('admin.layout')

@section('title', 'Restoranlar')
@section('page-title', 'Restoranlar')

@section('topbar-actions')
    <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary">+ Restoran qo'shish</a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">🍽️ Barcha restoranlar ({{ $restaurants->total() }})</div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Restoran</th>
                    <th>Egasi</th>
                    <th>Manzil</th>
                    <th>Yetkazish</th>
                    <th>Reyting</th>
                    <th>Status</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($restaurants as $r)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            @if($r->image)
                                <img src="{{ Storage::url($r->image) }}" class="img-preview">
                            @else
                                <div class="img-placeholder">🍽️</div>
                            @endif
                            <div>
                                <div style="font-weight:700;">{{ $r->name }}</div>
                                <div style="font-size:0.75rem; color:var(--muted);">{{ $r->delivery_time }} daqiqa</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $r->user->name ?? '—' }}</td>
                    <td style="color:var(--muted); font-size:0.85rem;">{{ $r->address ?? '—' }}</td>
                    <td>{{ number_format($r->delivery_fee, 0) }} so'm</td>
                    <td>
                        @if($r->rating > 0)
                            <span style="color:#FFB300; font-weight:700;">★ {{ $r->rating }}</span>
                        @else
                            <span style="color:var(--muted);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($r->is_active)
                            <span class="badge badge-green">✅ Faol</span>
                        @else
                            <span class="badge badge-red">❌ Nofaol</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('admin.restaurants.edit', $r) }}" class="btn btn-ghost btn-sm">✏️ Tahrir</a>
                            <form method="POST" action="{{ route('admin.restaurants.toggle', $r) }}">
                                @csrf
                                <button class="btn btn-ghost btn-sm">
                                    {{ $r->is_active ? '🔴 O\'chir' : '🟢 Yoq' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.restaurants.destroy', $r) }}" onsubmit="return confirm('O\'chirilsinmi?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding:60px; color:var(--muted);">
                    Hech qanday restoran yo'q.<br>
                    <a href="{{ route('admin.restaurants.create') }}" style="color:var(--primary); font-weight:700;">+ Birinchi restoran qo'shing</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($restaurants->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $restaurants->links() }}
    </div>
    @endif
</div>

@endsection