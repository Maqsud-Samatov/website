<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{

    protected $table = 'foods';
    
    protected $fillable = [
        'restaurant_id', 'category_id', 'name', 'description',
        'price', 'discount_price', 'image', 'ingredients',
        'calories', 'prep_time', 'is_available', 'is_popular'
    ];

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getActivePriceAttribute() {
        return $this->discount_price ?? $this->price;
    }
}