<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use Illuminate\Support\facades\Auth;

class OrderController extends Controller
{

    public function detail($id)
    {
    	$item = Item::find($id);
        return view('order.detail', ['item' => $item]);
    }

    public function add($id)
    {
    	$item = Item::find($id);
        $cart = session('cart');
        if(empty($cart)){
            $cart = array();
        }
        $cart[] = $item;
        session(['cart' => $cart]);
        return redirect('cart');
    }

    public function cart()
    {
print_r(session('cart'));
exit;
    }

    public function save(Request $request)
    {
        $this->validate($request, Item::$rules);
        $item = new Item;
        $form = $request->all();
        unset($form['_token']);

        if(isset($form["id"]) && !empty($form["id"])){
            $item = Item::firstOrNew(['id' => $form["id"]]);
        }
        $item->fill($form);
        $item->save();
        
        return redirect('admin/item');
    }

    public function list()
   {
        //セッションの内容を取得
        $orders = session('cart');
        return view('cart.list', ['orders' => $orders]);
     }

    public function detail($id)
   {
	$item = Item::find($id);
	return view('admin.item.detail', ['item' => $item]);

     }
}
