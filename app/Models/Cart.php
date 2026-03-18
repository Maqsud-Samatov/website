<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'food_id', 'restaurant_id', 'quantity'];

    public function food() {
        return $this->belongsTo(Food::class);
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }
}