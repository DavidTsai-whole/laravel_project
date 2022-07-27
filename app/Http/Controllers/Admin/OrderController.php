<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrdersDataTable;
use App\Exports\OrdersExport;
use App\Exports\OrdersMultipleExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderDelivery;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // ceil無條件進位, floor無條件捨去
        // whereHas 查詢關係是否存在，至少要有一筆
        // 'orderItems.product' 是兩個都可以取到
        $orderCount = Order::whereHas('orderItems')->count();
        $dataPerPage = 2;
        $orderPages = ceil($orderCount / $dataPerPage);
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1 ;
        $orders = Order::with(['user','orderItems.product'])->orderBy('created_at', 'desc')
                                ->offset($dataPerPage * ($currentPage -1))
                                ->limit($dataPerPage)
                                ->whereHas('orderItems')
                                ->get();

        return view('admin.orders.index', ['orders' => $orders, 'orderPages' => $orderPages, 'orderCount' => $orderCount]);
    }

    public function delivery($id){
        // user Model有引入Notifications
        $order = Order::find($id);
        if($order->is_shipped) {
            return response(['result' => false]);
        }
        else{
            $order->update(['is_shipped' => true]);
            $order->user->notify(new OrderDelivery);
            return  response(['result' => true]);
        }


    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function exportByShipped()
    {
        return Excel::download(new OrdersMultipleExport, 'orders_by_shipped.xlsx');
    }

    public function datatable(OrdersDataTable $dataTable)
    {
        return $dataTable->render('admin.orders.datatable');
    }
}
