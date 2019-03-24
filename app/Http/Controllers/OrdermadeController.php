<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;
use App\Orderdetail;

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
        $this->validate($request, Order::$rules);
        //�J�[�g�̒��g���m�F
        $cart = session('cart');
        //�J�[�g�̒��g�������ꍇ�̓J�[�g�Ɉړ��i�������Ƃ��m�F�����邽�߁j
        if(empty($cart)){
            return redirect('cart');
        }else{
            foreach($cart as $v){
                $total = $total + $v->price;
            }
        }
        $form = $request->all();
        $order = new Order;
        $order->fill($form);
        //�Z�b�V�����ɓo�^
        session(['order' => $form]);
        return view('order.confirm', ['items' => $cart,'order' => $order,'total' => $total]);
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
