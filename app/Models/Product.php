<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Product extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function checkQuantity($quantity) {
        if($this->quantity < $quantity) {
            return false;
        }
        return true;
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'attachable');
    }
    // 做一個假屬性值
    public function getImageUrlAttribute()
    {
        $images = $this->images;
        if($images->isNotEmpty()) {
            return Storage::url($images->last()->path);
        }
    }
}
