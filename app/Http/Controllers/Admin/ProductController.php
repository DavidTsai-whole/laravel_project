<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productCount = Product::count();
        $dataPerPage = 2;
        $productPages = ceil($productCount / $dataPerPage);
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1 ;
        $products = Product::orderBy('created_at', 'desc')
                                ->offset($dataPerPage * ($currentPage -1))
                                ->limit($dataPerPage)
                                ->get();

        return view('admin.products.index', ['products' => $products, 'productPages' => $productPages, 'productCount' => $productCount]);
    }

    public function uploadImage(Request $request)
    {
        // dd($request)
        // input沒取到值 預設是null
        // redirect()->back()是前一頁意思
        // line36 form的input值
        // line 41 把檔案儲存在resources/storage/app/***   ，檔案存在public裡 這樣使用php artisan storage:link產生給外部讀取的假連結才能成功
        // use withErrors 可以在前端自動產生$errors使用
        $file = $request->file('product_image');

        $productId = $request->input('product_id');
        if(is_null($productId)) {
            return redirect()->back()->withErrors(['msg' => '參數錯誤']);
        }
        $product = Product::find($productId);
        $path = $file->store('public/images');
        $product->images()->create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
        ]);
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $file = $request->file('excel');
        Excel::import(new ProductsImport, $file);

        return redirect()->back();
    }

}
