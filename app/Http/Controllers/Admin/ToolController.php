<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Jobs\UpdateProductPrice;
class ToolController extends Controller
{
    public function updateProductPrice()
    {
        // 加上 onQueue 是可以自己決定jobs table裡的queue欄位值的名稱 預設是default
        // 啟動指令 php artisan queue:work database --queue=default
        $products = Product::all();
        foreach ($products as $product)
        {
            UpdateProductPrice::dispatch($product)->onQueue('tool');
        }
    }

    public function createProductRedis()
    {
        Redis::set('products', json_encode(Product::all()));
    }
}
