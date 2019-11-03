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
        $processed = null;
        foreach ($orders as $order) {
            $order = array_filter($order, function ($k) {
                return $k === 'id' ||
                    $k === 'user_id' ||
                    $k === 'state' ||
                    $k === 'product' ||
                    $k === 'rent_date_start' ||
                    $k === 'rent_date_expire';
            }, ARRAY_FILTER_USE_KEY);
            $processed = $orders;
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


    public function store(Product $product)
    {
        $user = auth()->user();
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
        $res = $order->with(['state', 'product'])->where('id', $order->id)->first();

        if ($res->user_id !== auth()->user()->id) {
            abort(403);
        }
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

        $ord = Order::where('id', $order->id)
            ->with(['state', 'product'])->first();
        if ($ord->user_id !== auth()->user()->id) {
            abort(403);
        }
        $updated = tap(
            $order->where('id', $order->id)->first(), function ($order) {
            $order->update([
                'rent_date_start' => request()->startDate,
                'rent_date_expire' => request()->expiryDate,
            ]);
        })->with(['state', 'product'])->where('id', $order->id)->first();
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
        $ord = Order::where('id', $order->id)->first();
        if ($ord->user_id !== auth()->user()->id) {
            abort(403);
        }
        $order->where('id', $order->id)->delete();
        return response()->json('Deleted successfully!');
    }

    public function rent(Order $order)
    {
        $ord = Order::where('id', $order->id)->first();
        if ($ord->user_id !== auth()->user()->id) {
            abort(403);
        }
        $rented = tap(
            $order->where('id', $order->id)->first(), function ($order) {
            $order->update([
                'state_id' => State::states()['pending']
            ]);
        })->with(['state','product'])->where('id', $order->id)->first();
        return response()->json($rented);
    }

    public function reject(Order $order)
    {
        $ord = Order::where('id',$order->id)->first();
        if ($ord->user_id !== auth()->user()->id) {
            abort(403);
        }
        $rejected = tap(
            $order->where('id', $order->id)->first(), function ($order) {
            $order->update([
                'state_id' => State::states()['available']
            ]);
        })->with(['state','product'])->where('id', $order->id)->first();

        return response()->json($rejected, 200);
    }
}
