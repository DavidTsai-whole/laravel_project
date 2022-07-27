<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateCartItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute 是必要的'
        ];
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|integer',
            'product_id' =>'required|integer',
            'quantity' =>'required|integer|between:1,10'
        ],  $messages);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $validatedData = $validator->validate();
        // 檢查產品數量夠不夠
        $product = Product::find($validatedData['product_id']);
        if(!$product->checkQuantity($validatedData['quantity'])){
            return response($product->title.'數量不足', 400);
        }
        $cart = Cart::find($validatedData['cart_id']);
        // 此種方法建的cartItems 就自動帶上cart_id;用model建的也會自動補上timestamp欄位(created_at..)
        $result = $cart->cartItems()->create(['product_id' => $product->id,
                                              'quantity' => $validatedData['quantity']]);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartItem $request, $id)
    {
        $form = $request->validated();
        $item = CartItem::find($id);
        // fill 先填好不儲存 可減少效能
        $item->fill(['quantity' => $form['quantity']]);
        $item->save();

        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // add withTrashed()-> 就可以出現已經被軟刪除的資料;如果真的要刪除資料delete要改成forceDelete();
        CartItem::find($id)->delete();
        return response()->json(true);
    }
}
