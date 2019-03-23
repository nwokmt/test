<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use App\Order;
use Illuminate\Support\facades\Auth;

class OrderController extends Controller
{
    public function list()
   {
        $orders = Order::with('details')->orderBy('updated_at',"desc")->get();
print_r($orders);
exit;
        return view('admin.order.list', ['orders' => $orders]);
     }

    public function detail($id)
   {
	$item = Item::find($id);
	return view('admin.item.detail', ['item' => $item]);

     }
}
