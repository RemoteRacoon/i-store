<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    private static $states = [
        'available' => 1,
        'pending' => 2,
        'confirmed' => 3,
    ];
    protected $table = 'states';

    public static function states()
    {
        return self::$states;
    }
}
