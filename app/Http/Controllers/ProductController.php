<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\Product;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Services\ShortUrlService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data = DB::table('products')->get();
        $data = json_decode(Redis::get('products'));
        return response($data);
    }

    public function checkProduct(Request $request)
    {
        $id = $request->all()['id'];
        $product = Product::find($id);
        if($product->quantity > 0) {
            return response(true);
        }else {
            return response(false);
        }

    }

    public function sharedUrl($id)
    {
        $service = new ShortUrlService();
        $url = $service->makeShortUrl("http://localhost:3000/products/$id");
        return response(['url' => $url]);
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
    public function store(CreateProduct $request)
    {
        $form = $request->validated();
        $product = new Product([
            'title' => $form['title'],
            'content' => $form['content'],
            'price' => $form['price'],
            'quantity' => $form['quantity']
        ]);
        $product->save();

        return response()->json(true);
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
    public function update(UpdateProduct $request, $id)
    {
        $form = $request->validated();
        $item = Product::find($id);
        // fill 先填好不儲存 可減少效能
        $item->fill(['quantity' => $form['quantity'],
                     'title' => $form['title'],
                     'content' => $form['content'],
                     'price' => $form['price']]);
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
        Product::find($id)->delete();
        return response()->json(true);
    }
}
