<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [''];
    // 有很多個 所以cartItems用複數
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
