<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogError extends Model
{
    use HasFactory;

     protected $guarded = [''];
     // $casts 定義這些屬性在被處理的時候會被當作什麼樣的資料類型
     protected $casts = [
        'trace' => 'array',
        'params' => 'array',
        'header' => 'array'
     ];

}
