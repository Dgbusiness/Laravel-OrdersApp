<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Product extends Model
{
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'orderProduct')->withPivot('product_id');
    }
}
