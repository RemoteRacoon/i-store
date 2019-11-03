<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'remember_token', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];
}
