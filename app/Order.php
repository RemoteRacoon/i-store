<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot as Pivot;

class Order extends Pivot
{
    protected $table = 'orders';
    protected $hidden = ['created_at', 'updated_at'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

}
