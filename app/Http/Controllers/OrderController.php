<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;
use App\Orderdetail;

class OrderController extends Controller
{

    //�ڍ׉��
    public function detail($id)
    {
    	$item = Item::find($id);
        return view('order.detail', ['item' => $item]);
    }

    //�J�[�g�ɒǉ�
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

    //�J�[�g����폜
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

    //�J�[�g�̒��g�ꗗ
    public function cart()
    {
        return view('order.list', ['items' => session('cart')]);
    }

    //��������
    public function order()
    {
        //�J�[�g�̒��g���m�F
        $cart = session('cart');
        //�J�[�g�̒��g�������ꍇ�̓J�[�g�Ɉړ��i�������Ƃ��m�F�����邽�߁j
        if(empty($cart)){
            return redirect('cart');
        }
        return view('order.form', ['items' => session('cart')]);
    }

    //�����m�F
    public function confirm(Request $request)
    {
        //�o���f�[�V�����`�F�b�N
        $this->validate($request, Order::$rules);
        //�J�[�g�̒��g���m�F
        $cart = session('cart');
        //�J�[�g�̒��g�������ꍇ�̓J�[�g�Ɉړ��i�������Ƃ��m�F�����邽�߁j
        if(empty($cart)){
            return redirect('cart');
        }
        $form = $request->all();
        $order = new Order;
        $order->fill($form);
        //�Z�b�V�����ɓo�^
        session(['order' => $form]);
        return view('order.confirm', ['items' => session('cart'),'order' => $form]);
    }

    //�����m��
    public function save()
    {
        //�J�[�g�̒��g���m�F
        $cart = session('cart');
        $form = session('order');
        //�J�[�g�̒��g�������܂��͒������e���ꍇ�̓J�[�g�Ɉړ��i�������Ƃ��m�F�����邽�߁j
        if(empty($cart) || empty($form)){
            return redirect('cart');
        }
        $this->validate($form, Order::$rules);
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
