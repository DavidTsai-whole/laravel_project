<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Laravel\Passport\Passport;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;
    private $fakeUser;

    protected function setup(): void
    {
        //actingAs 表現的像
        parent::setUp();
        $this->fakeUser = User::create(['name' => 'john',
                                        'email' => 'john@gmail.com',
                                        'password' => 12345678]);
        Passport::actingAs($this->fakeUser);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $cart = Cart::factory()->create([
            'user_id' => $this->fakeUser->id,
        ]);
        $product = Product::factory()->create();
        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 2]
        );
        $response->assertOk();

        // 檢查數量邏輯 less()是自訂義涵式
        $product = Product::factory()->less()->create();
        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 10]
        );
        $this->assertEquals($product->title.'數量不足', $response->getContent());

        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 9999]
        );
        $response->assertStatus(400);
    }

    public function testUpdate()
    {
        // getContent() 會回傳在CartItemController回傳的值
        // add refresh() 才會看到改變之後的結果 ex:update後
        // $cart寫法都可以
        $cartItem = CartItem::factory()->create();
        $response = $this->call(
            'PUT',
            'cart-items/'.$cartItem->id,
            ['quantity' => 8]
        );
        $this->assertEquals('true', $response->getContent());

        $cartItem->refresh();
        $this->assertEquals(8, $cartItem->quantity);
    }

    public function testDestory(){
        $cart = Cart::factory()->create([
            'user_id' => $this->fakeUser->id,
        ]);
        $product = Product::factory()->make();
        $cartItem = $cart->cartItems()->create(['product_id' => $product->id, 'quantity' => 10]);
        $response = $this->call(
            'DELETE',
            'cart-items/'.$cartItem->id,
        );
        $response->assertOk();
        $cartItem = CartItem::find($cartItem->id);
        $this->assertNull($cartItem);
    }
}
