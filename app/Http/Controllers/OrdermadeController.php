<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Ordermade;
use Illuminate\Support\Facades\Config;

class OrdermadeController extends Controller
{

    //注文入力
    public function order()
    {
        return view('ordermade.form');
    }

    //注文確認
    public function confirm(Request $request)
    {
        $total = 0;
        //バリデーションチェック
        $this->validate($request, Ordermade::$rules);
        $form = $request->all();
        $order = new Ordermade;
        $order->fill($form);
        //セッションに登録
        session(['order' => $form]);
        //料金
        $orderMadePrice = Config::get('const.orderMadePrice');
        return view('order.confirm', ['order' => $order,'orderMadePrice' => $orderMadePrice[$form["type"]]]);
    }

    //注文確定
    public function save(Request $request)
    {
        //カートの中身を確認
        $cart = session('cart');
        $form = session('order');
        //カートの中身が無いまたは注文内容が場合はカートに移動（無いことを確認させるため）
        if(empty($cart) || empty($form)){
            return redirect('cart');
        }
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
