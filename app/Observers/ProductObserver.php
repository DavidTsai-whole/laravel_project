<?php

namespace App\Observers;

use App\Models\Product;
use App\Notifications\ProductReplenish;
class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //dd($product);
        // 用上述方法看傳來的資料 #號開頭的用get方式可以取值
        // 做產品補貨的通知
        $changes = $product->getChanges();
        $original = $product->getOriginal();
        if(isset($changes['quantity']) && $product->quantity > 0 && $original['quantity'] == 0) {
            foreach ($product->favorite_users as $user) {
                $user->notify(new ProductReplenish($product));
            };
        }
    }
    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
