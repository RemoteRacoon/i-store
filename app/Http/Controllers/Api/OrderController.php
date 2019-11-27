<?php

namespace App\Http\Controllers\Api;

use App\Facades\OrderService;
use App\Order;
use App\Product;
use App\State;
use App\Http\Controllers\Controller;
use App\Traits\OrderProcessable;
use App\User;
use Illuminate\Http\Request;


class OrderController extends Controller
{

    use OrderProcessable;


    public function index()
    {
        $user = auth()->user();
        $res = $user->orders;
        $res = $this->processOrder($res);
        return response()->json($res, 200);
    }


    public function store($product_id)
    {
        $user = auth()->user();
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product_id
        ]);
        $res = $order->save();
        return response()->json($res);
    }


    public function update($order_id, Request $request)
    {

        $user = auth()->user();
        $ord = $user->orders()->where('id', $order_id)->first();

        $updated = tap(
            $ord, function ($order) {
            $order->update([
                'rent_date_start' => request()->startDate,
                'rent_date_expire' => request()->expiryDate,
            ]);
        });
        return response()->json($updated, 200);
    }

    public function destroy($order_id)
    {
        $user = auth()->user();
        $ord = $user->orders()->where('id', $order_id)->first();
        $ord->delete();
        return response()->json('Deleted successfully!');
    }

    public function rent($order_id)
    {
        $user = auth()->user();
        $updated = tap($user->orders()->where('id', $order_id))
            ->update([
                'state_id' => State::states()['pending']
            ])->first();

        return response()->json($updated);
    }

    public function reject($order_id)
    {
        $user = auth()->user();
        $updated = tap($user->orders()->where('id', $order_id))
            ->update([
                'state_id' => State::states()['available']
            ])->first();
        return response()->json($updated, 200);
    }

    public function confirm($order_id)
    {
        $user = Order::where('id', $order_id)->first()->user;
        $confirmed = tap($user->orders()->where('id', $order_id))->update([
            'state_id' => State::states()['confirmed']
        ])->first();
        return OrderService::confirm($confirmed, $user);
    }

}
