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
}

