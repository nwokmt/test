<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;

class OrderController extends Controller
{
    public function list()
   {
/*
        $orders = DB::table('orders')
                    ->join('orderdetails','orders.id','=','orderdetails.order_id')
                    ->join('items','items.id','=','orderdetails.item_id')
                    ->select('orders.*', 'items.*')
                    ->orderBy('orders.updated_at',"desc")
                    ->get();
*/
        $orders = Order::orderBy('orders.updated_at',"desc")->get();
print_r($orders);
print_r($orders->details);
exit;
        return view('admin.order.list', ['orders' => $orders]);
     }

    public function detail($id)
   {
	$item = Item::find($id);
	return view('admin.item.detail', ['item' => $item]);

     }
}
