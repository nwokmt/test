<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Ordermade;
use Illuminate\Support\Facades\Config;

class OrdermadeController extends Controller
{

    //��������
    public function order()
    {
        return view('ordermade.form');
    }

    //�����m�F
    public function confirm(Request $request)
    {
        $total = 0;
        //�o���f�[�V�����`�F�b�N
        $this->validate($request, Ordermade::$rules);
        $form = $request->all();
        $order = new Ordermade;
        $order->fill($form);
        //�Z�b�V�����ɓo�^
        session(['order' => $form]);
        //����
        $orderMadePrice = Config::get('const.orderMadePrice');
        return view('order.confirm', ['order' => $order,'orderMadePrice' => $orderMadePrice[$form["type"]]]);
    }

    //�����m��
    public function save(Request $request)
    {
        //�J�[�g�̒��g���m�F
        $cart = session('cart');
        $form = session('order');
        //�J�[�g�̒��g�������܂��͒������e���ꍇ�̓J�[�g�Ɉړ��i�������Ƃ��m�F�����邽�߁j
        if(empty($cart) || empty($form)){
            return redirect('cart');
        }
        $order = new Order;
        unset($form['_token']);

        $order->fill($form);
        $order->save();
        $order_id = $order->id;
        //�ڍׂ�o�^
        foreach($cart as $v){
            $orderdetail = new Orderdetail;
            $orderdetail->order_id = $order_id;
            $orderdetail->item_id = $v->id;
            $orderdetail->save();
        }
        //�o�^��Z�b�V��������폜
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
        //�Z�b�V�����̓��e���擾
        $orders = session('cart');
        return view('cart.list', ['orders' => $orders]);
     }

}
