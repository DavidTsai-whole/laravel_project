<?php

namespace Database\Factories;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CartItem::class;
    public function definition()
    {
        return [
            'cart_id' => Cart::factory(),
            'quantity' => $this->faker->randomDigit,
            'product_id' => Product::factory(),

        ];
    }
}
