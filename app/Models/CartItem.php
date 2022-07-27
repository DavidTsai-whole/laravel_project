<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    // 可用 protected $fillable = ['quantity'];
     // 不可用 protected $guarded = ['quantity'];
     // protected $hidden;
     protected $guarded = [''];

     public function product(){
        return $this->belongsTo(Product::class);
     }

     public function cart(){
        return $this->belongsTo(Cart::class);
     }
}
