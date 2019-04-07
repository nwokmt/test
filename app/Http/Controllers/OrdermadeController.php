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
        //バリデーションチェック
        $this->validate($request, Ordermade::$rules);
        $form = $request->all();
        $ordermade = new Ordermade;
        $ordermade->fill($form);
        //セッションに登録
        session(['ordermade' => $form]);
        //料金
        $orderMadePrice = Config::get('const.orderMadePrice');
        return view('ordermade.confirm', ['ordermade' => $ordermade,'orderMadePrice' => $orderMadePrice[$form["type"]]]);
    }

    //注文確定
    public function save(Request $request)
    {
        $form = session('ordermade');
        //カートの中身が無いまたは注文内容が場合
        if(empty($form)){
            return redirect('/');
        }
        $ordermade = new Ordermade;
        unset($form['_token']);

        $ordermade->fill($form);
        $ordermade->save();
        //登録後セッションから削除
        session(['order' => null]);
        return redirect('thanks');
    }

    public function thanks()
   {
        return view('order.thanks');
     }

}
