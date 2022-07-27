<?php

namespace Database\Factories;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // make()是做資料庫裏面的暫存資料 create()是真的在資料庫建一筆資料
        //UserFactory並沒有指定id
        //$user = User::factory()->make();
        //line 27 意思是User::factory()->create() 並自動帶上此欄位的值
        return [
            'id' => $this->faker->randomDigit,
            'user_id' => User::factory()

        ];
    }
}
