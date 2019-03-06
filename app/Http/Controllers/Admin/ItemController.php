<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use Illuminate\Support\facades\Auth;

class ItemController extends Controller
{
    public function add($id)
    {
print_r($id);
exit;
    	$item = Item::find($id);
        return view('admin.item.form', ['item' => $item]);
    }

    public function edit(Request $request)
    {
print_r($request->all());
exit;
        $this->validate($request, Item::$rules);
        $item = new Item;
        $form = $request->all();
        unset($form['_token']);

        $item = Item::firstOrNew(['id' => Auth::id()]);
        $item->fill($form);
        $item->save();
        
        return redirect('admin/item');
    }

    public function front(Request $request)
   {
print_r($request->all());
exit;
	$id = Auth::id();
	$item = Item::find($request->user_id = $id);

	return view('admin.item.detail', ['item' => $item]);

     }
}
