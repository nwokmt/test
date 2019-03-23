<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;

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
        //セッションに登録
        session(['order' => $request]);
        return view('order.confirm', ['items' => session('cart'),'order' => $request]);
    }

    //注文確定
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

}
