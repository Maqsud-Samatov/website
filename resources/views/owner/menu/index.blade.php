@extends('owner.layout')
@section('title', 'Menyu')
@section('page-title', 'Menyu boshqaruvi')

@section('topbar-actions')
    <button onclick="openOwnerModal('addFoodModal')" class="owner-btn owner-btn-primary owner-btn-lg">
        + Taom qo'shish
    </button>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-title">🍽️ Menyu boshqaruvi</div>
        <div class="page-header-sub">{{ $restaurant->name }} — {{ $allFoods->count() }} ta taom</div>
    </div>
</div>

<div class="owner-menu-layout">

    <!-- LEFT: CATEGORIES -->
    <div class="owner-cat-panel">
        <div class="owner-cat-card">
            <div class="owner-cat-header">
                <div class="owner-cat-title">📂 Kategoriyalar</div>
                <span style="font-size:0.72rem; color:#8A92A0; font-weight:600;">{{ $categories->count() }} ta</span>
            </div>
            <div class="owner-cat-list">
                <button class="owner-cat-item active" onclick="filterCat('all', this)">
                    <span>🍽️ Barchasi</span>
                    <span class="owner-cat-count">{{ $allFoods->count() }}</span>
                </button>
                @foreach($categories as $cat)
                <button class="owner-cat-item" onclick="filterCat({{ $cat->id }}, this)">
                    <span>{{ $cat->name }}</span>
                    <span class="owner-cat-count">{{ $cat->foods->count() }}</span>
                </button>
                @endforeach
            </div>
            <div class="owner-cat-add">
                <form method="POST" action="{{ route('owner.categories.store') }}">
                    @csrf
                    <div class="owner-cat-add-row">
                        <input type="text" name="name" class="owner-cat-add-input" placeholder="Yangi kategoriya..." required>
                        <button type="submit" class="owner-btn owner-btn-primary owner-btn-sm">+</button>
                    </div>
                </form>
            </div>

            @if($categories->count() > 0)
            <div class="owner-cat-delete-list">
                <div style="font-size:0.68rem; font-weight:700; color:#B0B8C4; text-transform:uppercase; letter-spacing:1px; padding:4px 4px 8px;">O'chirish</div>
                @foreach($categories as $cat)
                <div class="owner-cat-delete-item">
                    <span>{{ $cat->name }} <span style="color:#B0B8C4;">({{ $cat->foods->count() }})</span></span>
                    <form method="POST" action="{{ route('owner.categories.destroy', $cat) }}" onsubmit="return confirm('O\'chirilsinmi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="owner-cat-delete-btn">🗑️</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- RIGHT: FOODS -->
    <div>
        <div class="owner-food-section-header">
            <div></div>
            <span class="owner-food-count" id="foodCount">{{ $allFoods->count() }} ta taom</span>
        </div>

        @if($allFoods->isEmpty())
            <div class="owner-empty">
                <div class="owner-empty-icon">🍽️</div>
                <h3>Hali taomlar yo'q</h3>
                <p>Birinchi taomingizni qo'shing va menyuni to'ldiring!</p>
                <button onclick="openOwnerModal('addFoodModal')" class="owner-btn owner-btn-primary owner-btn-lg">
                    + Birinchi taomni qo'shish
                </button>
            </div>
        @else
            <div class="owner-food-grid" id="foodGrid">
                @foreach($allFoods as $food)
                <div class="owner-food-card {{ !$food->is_available ? 'unavailable' : '' }}"
                     data-category="{{ $food->category_id }}">

                    <div class="owner-food-img-wrap">
                        @if($food->image)
                            <img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}">
                        @else
                            🍽️
                        @endif
                        @if($food->is_popular)
                            <span class="owner-food-popular">🔥 Popular</span>
                        @endif
                        <span class="owner-food-status {{ $food->is_available ? 'on' : 'off' }}">
                            {{ $food->is_available ? '✅ Mavjud' : '❌ Yo\'q' }}
                        </span>
                    </div>

                    <div class="owner-food-body">
                        <div class="owner-food-cat">{{ $food->category->name ?? 'Kategoriyasiz' }}</div>
                        <div class="owner-food-name">{{ $food->name }}</div>
                        @if($food->description)
                            <div class="owner-food-desc">{{ $food->description }}</div>
                        @endif
                        <div class="owner-food-footer">
                            <div class="owner-food-price">
                                {{ number_format($food->discount_price ?? $food->price, 0, '.', ' ') }} so'm
                                @if($food->discount_price)
                                    <span class="owner-food-old-price">{{ number_format($food->price, 0, '.', ' ') }}</span>
                                @endif
                            </div>
                            <div class="owner-food-meta">
                                @if($food->prep_time) <span>⏱ {{ $food->prep_time }}m</span> @endif
                                @if($food->calories) <span>🔥 {{ $food->calories }}</span> @endif
                            </div>
                        </div>

                        <div class="owner-food-actions">
                            <button class="owner-btn owner-btn-secondary owner-btn-sm" onclick="editFood({{ $food->id }})">
                                ✏️ Tahrir
                            </button>
                            <form method="POST" action="{{ route('owner.foods.toggle', $food) }}">
                                @csrf
                                <button type="submit" class="owner-btn owner-btn-sm {{ $food->is_available ? 'owner-btn-success' : 'owner-btn-secondary' }}">
                                    {{ $food->is_available ? '✅' : '❌' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('owner.foods.destroy', $food) }}" onsubmit="return confirm('O\'chirilsinmi?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="owner-btn owner-btn-danger owner-btn-sm">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- ADD FOOD MODAL -->
<div class="owner-modal-backdrop" id="addFoodModal">
    <div class="owner-modal">
        <div class="owner-modal-header">
            <div class="owner-modal-title">➕ Yangi taom qo'shish</div>
            <button class="owner-modal-close" onclick="closeOwnerModal('addFoodModal')">✕</button>
        </div>
        <div class="owner-modal-body">
            <form method="POST" action="{{ route('owner.foods.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="owner-form-group">
                    <label class="owner-form-label">Taom nomi *</label>
                    <input type="text" name="name" class="owner-form-input" placeholder="Masalan: Osh, Burger..." required>
                </div>

                <div class="owner-form-grid">
                    <div class="owner-form-group">
                        <label class="owner-form-label">Narxi (so'm) *</label>
                        <input type="number" name="price" class="owner-form-input" placeholder="50000" required>
                    </div>
                    <div class="owner-form-group">
                        <label class="owner-form-label">Chegirmali narx</label>
                        <input type="number" name="discount_price" class="owner-form-input" placeholder="Ixtiyoriy">
                    </div>
                </div>

                <div class="owner-form-group">
                    <label class="owner-form-label">Kategoriya</label>
                    <select name="category_id" class="owner-form-input">
                        <option value="">— Kategoriyasiz —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="owner-form-group">
                    <label class="owner-form-label">Tavsif</label>
                    <textarea name="description" class="owner-form-input" placeholder="Taom haqida qisqacha..."></textarea>
                </div>

                <div class="owner-form-group">
                    <label class="owner-form-label">Tarkibi (ingredientlar)</label>
                    <input type="text" name="ingredients" class="owner-form-input" placeholder="Guruch, go'sht, sabzi...">
                </div>

                <div class="owner-form-grid">
                    <div class="owner-form-group">
                        <label class="owner-form-label">Tayyorlash vaqti (min)</label>
                        <input type="number" name="prep_time" class="owner-form-input" value="15">
                    </div>
                    <div class="owner-form-group">
                        <label class="owner-form-label">Kaloriya</label>
                        <input type="number" name="calories" class="owner-form-input" placeholder="Ixtiyoriy">
                    </div>
                </div>

                <div class="owner-form-group">
                    <label class="owner-form-label">Rasm</label>
                    <input type="file" name="image" class="owner-form-input" accept="image/*">
                    <div class="owner-form-hint">JPG, PNG — max 3MB</div>
                </div>

                <div class="owner-check-row">
                    <label class="owner-check-label">
                        <input type="checkbox" name="is_available" value="1" checked> Mavjud
                    </label>
                    <label class="owner-check-label">
                        <input type="checkbox" name="is_popular" value="1"> 🔥 Popular
                    </label>
                </div>

                <button type="submit" class="owner-form-submit">✅ Taom qo'shish</button>
            </form>
        </div>
    </div>
</div>

<!-- EDIT FOOD MODAL -->
<div class="owner-modal-backdrop" id="editFoodModal">
    <div class="owner-modal">
        <div class="owner-modal-header">
            <div class="owner-modal-title">✏️ Taomni tahrirlash</div>
            <button class="owner-modal-close" onclick="closeOwnerModal('editFoodModal')">✕</button>
        </div>
        <div class="owner-modal-body" id="editFoodBody">
            <div style="text-align:center; padding:40px; color:#8A92A0;">Yuklanmoqda...</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openOwnerModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeOwnerModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.owner-modal-backdrop').forEach(b => {
        b.addEventListener('click', e => { if (e.target === b) closeOwnerModal(b.id); });
    });

    function filterCat(catId, el) {
        document.querySelectorAll('.owner-cat-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
        let count = 0;
        document.querySelectorAll('.owner-food-card').forEach(card => {
            const show = catId === 'all' || card.dataset.category == catId;
            card.style.display = show ? '' : 'none';
            if (show) count++;
        });
        document.getElementById('foodCount').textContent = count + ' ta taom';
    }

    function editFood(foodId) {
        openOwnerModal('editFoodModal');
        document.getElementById('editFoodBody').innerHTML =
            '<div style="text-align:center; padding:40px; color:#8A92A0;">Yuklanmoqda...</div>';

        fetch(`/owner/foods/${foodId}/edit`)
            .then(r => r.json())
            .then(data => {
                const f = data.food;
                const cats = data.categories;
                let opts = '<option value="">— Kategoriyasiz —</option>';
                cats.forEach(c => {
                    opts += `<option value="${c.id}" ${f.category_id == c.id ? 'selected':''}>${c.name}</option>`;
                });
                document.getElementById('editFoodBody').innerHTML = `
                    <form method="POST" action="/owner/foods/${f.id}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="owner-form-group">
                            <label class="owner-form-label">Taom nomi *</label>
                            <input type="text" name="name" class="owner-form-input" value="${f.name}" required>
                        </div>
                        <div class="owner-form-grid">
                            <div class="owner-form-group">
                                <label class="owner-form-label">Narxi (so'm) *</label>
                                <input type="number" name="price" class="owner-form-input" value="${f.price}" required>
                            </div>
                            <div class="owner-form-group">
                                <label class="owner-form-label">Chegirmali narx</label>
                                <input type="number" name="discount_price" class="owner-form-input" value="${f.discount_price || ''}">
                            </div>
                        </div>
                        <div class="owner-form-group">
                            <label class="owner-form-label">Kategoriya</label>
                            <select name="category_id" class="owner-form-input">${opts}</select>
                        </div>
                        <div class="owner-form-group">
                            <label class="owner-form-label">Tavsif</label>
                            <textarea name="description" class="owner-form-input">${f.description || ''}</textarea>
                        </div>
                        <div class="owner-form-group">
                            <label class="owner-form-label">Tarkibi</label>
                            <input type="text" name="ingredients" class="owner-form-input" value="${f.ingredients || ''}">
                        </div>
                        <div class="owner-form-grid">
                            <div class="owner-form-group">
                                <label class="owner-form-label">Tayyorlash vaqti (min)</label>
                                <input type="number" name="prep_time" class="owner-form-input" value="${f.prep_time || 15}">
                            </div>
                            <div class="owner-form-group">
                                <label class="owner-form-label">Kaloriya</label>
                                <input type="number" name="calories" class="owner-form-input" value="${f.calories || ''}">
                            </div>
                        </div>
                        <div class="owner-form-group">
                            <label class="owner-form-label">Yangi rasm</label>
                            <input type="file" name="image" class="owner-form-input" accept="image/*">
                        </div>
                        <div class="owner-check-row">
                            <label class="owner-check-label">
                                <input type="checkbox" name="is_available" value="1" ${f.is_available ? 'checked':''}> Mavjud
                            </label>
                            <label class="owner-check-label">
                                <input type="checkbox" name="is_popular" value="1" ${f.is_popular ? 'checked':''}> 🔥 Popular
                            </label>
                        </div>
                        <button type="submit" class="owner-form-submit">💾 Saqlash</button>
                    </form>`;
            });
    }

    @if($errors->any()) openOwnerModal('addFoodModal'); @endif
</script>
@endpush