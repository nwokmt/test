<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = array('id');

    public static $rules =array(
        'address' => 'required',
        'name' => 'required',
        'payment' => 'required',
    );
    public function details()
    {
        return $this->hasMany('App\Orderdetail');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'orderdetails', 'item_id', 'order_id');
    }
}

