<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\State;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 'user')->get();
        return response()->json($users);
    }

    public function show(User $user)
    {
        $orders = Order::where([
            ['user_id', $user->id],
            ['state_id', State::states()['pending']]
        ])->with(['state', 'product'])->get();
        return response()->json($orders, 200);
    }

}
