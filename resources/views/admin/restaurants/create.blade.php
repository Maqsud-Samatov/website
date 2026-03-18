@extends('admin.layout')

@section('title', isset($restaurant) ? 'Restoran tahrirlash' : 'Restoran qo\'shish')
@section('page-title', isset($restaurant) ? 'Restoran tahrirlash' : 'Restoran qo\'shish')

@section('topbar-actions')
    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-ghost">← Orqaga</a>
@endsection

@section('content')

<div style="max-width:800px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ isset($restaurant) ? '✏️ Restoran tahrirlash' : '➕ Yangi restoran' }}</div>
        </div>
        <div class="card-body">
            <form method="POST"
                action="{{ isset($restaurant) ? route('admin.restaurants.update', $restaurant) : route('admin.restaurants.store') }}"
                enctype="multipart/form-data">
                @csrf
                @isset($restaurant) @method('PUT') @endisset

                <div class="form-grid">
                    <div class="form-group">
                        <label>Restoran nomi *</label>
                        <input type="text" name="name" value="{{ old('name', $restaurant->name ?? '') }}" placeholder="Masalan: Pizza House" required>
                        @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Egasi (Owner) *</label>
                        <select name="user_id" required>
                            <option value="">— Tanlang —</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ (old('user_id', $restaurant->user_id ?? '') == $owner->id) ? 'selected' : '' }}>
                                    {{ $owner->name }} ({{ $owner->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Tavsif</label>
                    <textarea name="description" placeholder="Restoran haqida qisqacha...">{{ old('description', $restaurant->description ?? '') }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" name="phone" value="{{ old('phone', $restaurant->phone ?? '') }}" placeholder="+998 90 123 45 67">
                    </div>
                    <div class="form-group">
                        <label>Manzil</label>
                        <input type="text" name="address" value="{{ old('address', $restaurant->address ?? '') }}" placeholder="Ko'cha, uy...">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Yetkazish narxi (so'm)</label>
                        <input type="number" name="delivery_fee" value="{{ old('delivery_fee', $restaurant->delivery_fee ?? 0) }}" placeholder="5000">
                    </div>
                    <div class="form-group">
                        <label>Yetkazish vaqti (daqiqa)</label>
                        <input type="number" name="delivery_time" value="{{ old('delivery_time', $restaurant->delivery_time ?? 30) }}" placeholder="30">
                    </div>
                </div>

                <div class="form-group">
                    <label>Rasm</label>
                    @isset($restaurant)
                        @if($restaurant->image)
                            <div style="margin-bottom:10px;">
                                <img src="{{ Storage::url($restaurant->image) }}" style="width:120px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--border);">
                            </div>
                        @endif
                    @endisset
                    <input type="file" name="image" accept="image/*">
                    <div class="form-hint">JPG, PNG — max 2MB</div>
                </div>

                <div style="display:flex; gap:10px; margin-top:8px;">
                    <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $restaurant->is_active ?? true) ? 'checked' : '' }} style="width:16px; height:16px;">
                        Faol holat
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer; margin-left:20px;">
                        <input type="checkbox" name="is_open" value="1" {{ old('is_open', $restaurant->is_open ?? true) ? 'checked' : '' }} style="width:16px; height:16px;">
                        Hozir ochiq
                    </label>
                </div>

                <div style="margin-top:28px; display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($restaurant) ? '💾 Saqlash' : '✅ Qo\'shish' }}
                    </button>
                    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-ghost">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection