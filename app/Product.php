<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function users() {
        return $this->belongsToMany(User::class, 'orders');
    }

}
