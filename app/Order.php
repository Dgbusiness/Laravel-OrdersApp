<?php

namespace App;

use App\User;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'userOrder')->withPivot('user_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'orderProduct')->withPivot('product_id');
    }
}
