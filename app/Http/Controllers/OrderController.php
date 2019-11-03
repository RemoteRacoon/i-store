<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class OrderController extends Controller
{

    private function processOrder(Collection $orders)
    {
        $orders = $orders->toArray();
        $processed = [];
        foreach ($orders as $order) {
            $order = array_filter($order, function ($k) {
                return $k === 'id' || $k === 'state' || $k === 'product' || $k === 'rent_date_start' || $k === 'rent_date_expire';
            }, ARRAY_FILTER_USE_KEY);
            array_push($processed, $order);
        }
        return $processed;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $res = Order::where('user_id', $user->id)
            ->with(['state', 'product'])->get();
        $res = $this->processOrder($res);
        return response()->json($res, 200);
    }


    public function store(User $user, Product $product)
    {
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
        $res = $order->save();
        return response()->json($res);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $res = $order->with(['state', 'product'])->where('id', $order->id)->get();
        $res = $this->processOrder($res);
        return response()->json($res, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order)
    {
        $res = tap($order->where('id', $order->id)->update([
            'rent_date_start' => request()->startDate,
            'rent_date_expire' => request()->expiryDate,
        ]))->get();
        $updated  = $this->processOrder($res);
        return response()->json($updated, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->where('id', $order->id)->delete();
        return response()->json('Deleted successfully!');
    }

    public function rent(User $user, Order $order)
    {
        $res = $order->where('id', $order->id)->update([
            'state_id' => State::states()['pending']
        ]);
        return response()->json($res);
    }

    public function reject(User $user, Order $order)
    {
        $res = $order->where('id', $order->id)
            ->update([
                'state_id' => State::states()['available']
            ]);

//        return response()->json('Updated successfully!');
        return response()->json($res, 200);
    }
}
