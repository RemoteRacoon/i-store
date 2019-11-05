<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 'user')->paginate(5);
        return response()->json($users);
    }

    public function show(User $user)
    {
        $orders = Order::where('user_id', $user->id)->with(['state', 'product'])->paginate(10);
        return response()->json(compact('user', 'orders'), 200);
    }

}
