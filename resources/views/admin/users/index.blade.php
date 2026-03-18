@extends('admin.layout')
@section('title', 'Foydalanuvchilar')
@section('page-title', 'Foydalanuvchilar')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-title">👥 Foydalanuvchilar</div>
        <div class="page-header-sub">Jami {{ $users->total() }} ta foydalanuvchi</div>
    </div>
</div>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foydalanuvchi</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ro'yxatdan o'tgan</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:#888; font-size:0.8rem;">{{ $user->id }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#FF5722,#FF7043); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:0.88rem; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="admin-table .td-name" style="font-weight:700; font-size:0.88rem;">{{ $user->name }}</div>
                                @if($user->phone)
                                    <div style="font-size:0.75rem; color:#888;">{{ $user->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:#555; font-size:0.88rem;">{{ $user->email }}</td>
                    <td>
                        <span class="admin-badge {{ match($user->role) {
                            'admin'    => 'purple',
                            'owner'    => 'blue',
                            'delivery' => 'orange',
                            default    => 'gray'
                        } }}">
                            {{ match($user->role) {
                                'admin'    => '👑 Admin',
                                'owner'    => '🍽️ Egasi',
                                'delivery' => '🛵 Kuryer',
                                default    => '👤 Mijoz'
                            } }}
                        </span>
                    </td>
                    <td style="color:#888; font-size:0.8rem;">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                @csrf
                                <select name="role" onchange="this.form.submit()"
                                    style="padding:5px 10px; border:1.5px solid #E5E7EB; border-radius:8px; font-family:var(--font); font-size:0.78rem; cursor:pointer; background:white;">
                                    <option value="user"     {{ $user->role === 'user'     ? 'selected' : '' }}>Mijoz</option>
                                    <option value="owner"    {{ $user->role === 'owner'    ? 'selected' : '' }}>Egasi</option>
                                    <option value="delivery" {{ $user->role === 'delivery' ? 'selected' : '' }}>Kuryer</option>
                                    <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:48px; color:#888;">
                        <div style="font-size:2.5rem; margin-bottom:10px;">👥</div>
                        Foydalanuvchilar yo'q
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:16px 22px; border-top:1px solid #F0F2F5;">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection