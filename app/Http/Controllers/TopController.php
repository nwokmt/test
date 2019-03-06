<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class TopController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('updated_at',"desc")->get();
        return view('welcome', ['items' => $items]);
    }
}
