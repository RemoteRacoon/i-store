<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['rent_date_start', 'rent_date_expire'];


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

}
