<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'image',
        'phone', 'address', 'city', 'delivery_fee',
        'delivery_time', 'min_order', 'rating', 'rating_count',
        'is_active', 'is_open'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function foods() {
        return $this->hasMany(Food::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}