<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use App\Order;
use App\Orderdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Auth;

class OrderController extends Controller
{
    public function list()
   {
        $orders = Order::orderBy('orders.updated_at',"desc")->get();
        return view('admin.order.list', ['orders' => $orders]);
     }

    public function detail($id)
   {
	$orderdetail = Orderdetail:::where('order_id',$id)->orderBy('id',"asc")->get();
print_r($orderdetail);
exit;
	return view('admin.item.detail', ['item' => $item]);

     }
}
