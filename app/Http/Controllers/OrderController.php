<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;
use App\Orderdetail;

class OrderController extends Controller
{

    //詳細画面
    public function detail($id)
    {
    	$item = Item::find($id);
        return view('order.detail', ['item' => $item]);
    }

    //カートに追加
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

    //カートから削除
    public function remove($id)
    {
        $cart = session('cart');
        if(!empty($cart)){
            unset($cart[$id]);
            $cart = array_values($cart);
            session(['cart' => $cart]);
        }
        return redirect('cart');
    }

    //カートの中身一覧
    public function cart()
    {
        return view('order.list', ['items' => session('cart')]);
    }

    //注文入力
    public function order()
    {
        //カートの中身を確認
        $cart = session('cart');
        //カートの中身が無い場合はカートに移動（無いことを確認させるため）
        if(empty($cart)){
            return redirect('cart');
        }
        return view('order.form', ['items' => session('cart')]);
    }

    //注文確認
    public function confirm(Request $request)
    {
        //バリデーションチェック
        $this->validate($request, Order::$rules);
        //カートの中身を確認
        $cart = session('cart');
        //カートの中身が無い場合はカートに移動（無いことを確認させるため）
        if(empty($cart)){
            return redirect('cart');
        }
        $form = $request->all();
print_r($form);
exit;
        //セッションに登録
        session(['order' => $form]);
        return view('order.confirm', ['items' => session('cart'),'order' => $form]);
    }

    //注文確定
    public function save()
    {
        //カートの中身を確認
        $cart = session('cart');
        $form = session('order');
        //カートの中身が無いまたは注文内容が場合はカートに移動（無いことを確認させるため）
        if(empty($cart) || empty($form)){
            return redirect('cart');
        }
        $this->validate($form, Order::$rules);
        $order = new Order;
        unset($form['_token']);

        $order->fill($form);
        $order->save();
        $order_id = $order->id;
        //詳細を登録
        foreach($cart as $v){
            $orderdetail = new Orderdetail;
            $orderdetail->order_id = $order_id;
            $orderdetail->item_id = $v->id;
            $orderdetail->save();
        }
        //登録後セッションから削除
        session(['cart' => null]);
        session(['order' => null]);
        return redirect('thanks');
    }

    public function thanks()
   {
        return view('order.thanks');
     }

    public function list()
   {
        //セッションの内容を取得
        $orders = session('cart');
        return view('cart.list', ['orders' => $orders]);
     }

}
