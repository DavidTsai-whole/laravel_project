<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
// DatabaseNotification就是資料庫裡面notifications的model
use Illuminate\Notifications\DatabaseNotification;
class WebController extends Controller
{
    public $notifications = [];

    public function __construct()
    {
        $user = User::find(2);
        $this->notifications = $user->notifications ?? [];
    }
    public function index()
    {
        // user Model有引入Notifications
        $products = Product::all();

        return view('web.index', ['products' => $products, 'notifications' => $this->notifications]);
    }

    public function contactUs()
    {
        return view('web.contact_us',['notifications' => $this->notifications]);
    }

    public function readNotification(Request $request)
    {
        $id = $request->all()['id'];
        // markAsRead() 是DatabaseNotification 內建函式 會帶上read_at的值
        DatabaseNotification::find($id)->markAsRead();
        return response(['result' => true]);
    }
}
