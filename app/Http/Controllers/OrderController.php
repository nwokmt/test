<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;

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
        //�Z�b�V�����ɓo�^
        session(['order' => $request]);
        return view('order.confirm', ['items' => session('cart'),'order' => $request]);
    }

    //�����m��
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
        //�Z�b�V�����̓��e���擾
        $orders = session('cart');
        return view('cart.list', ['orders' => $orders]);
     }

}
