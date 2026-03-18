<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'restaurant_id', 'delivery_user_id',
        'subtotal', 'delivery_fee', 'total', 'status',
        'payment_method', 'payment_status',
        'address', 'phone', 'note', 'delivered_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery() {
        return $this->belongsTo(User::class, 'delivery_user_id');
    }

    public function getStatusLabelAttribute() {
        return match($this->status) {
            'pending'    => ['label' => 'Kutilmoqda',      'color' => 'orange'],
            'confirmed'  => ['label' => 'Tasdiqlandi',     'color' => 'blue'],
            'preparing'  => ['label' => 'Tayyorlanmoqda',  'color' => 'purple'],
            'on_the_way' => ['label' => 'Yo\'lda',         'color' => 'indigo'],
            'delivered'  => ['label' => 'Yetkazildi',      'color' => 'green'],
            'cancelled'  => ['label' => 'Bekor qilindi',   'color' => 'red'],
            default      => ['label' => 'Noma\'lum',       'color' => 'gray'],
        };
    }
}