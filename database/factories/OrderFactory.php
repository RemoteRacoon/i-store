<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;
use App\Product;
use App\User;
use App\State;

function getProductsIDs()
{
    $ids = Product::all()->pluck('id')->toArray();
    return $ids;
}

function getUsersIDs()
{
    $ids = User::all()->pluck('id');
    return $ids;
}

function getStatesIDs()
{
    $ids = State::all()->pluck('id');
    return $ids;
}

function generate()
{
    $states_ids = getStatesIDs();
    $state_id = $states_ids[rand(0, sizeof($states_ids) - 1)];
    do {
        $user_ids = getUsersIDs();
        $product_ids = getProductsIDs();

        $user_id = $user_ids[rand(0, sizeof($user_ids) - 1)];
        $product_id = $product_ids[rand(0, sizeof($product_ids) - 1)];


        $res = Order::where('user_id', $user_id)
            ->where('product_id', $product_id)->get()->toArray();
        if (empty($res)) {
            return compact('user_id', 'product_id', 'state_id');
        }
    } while (1);


}

$factory->define(Order::class, function (Faker $faker) {
    return generate();
});
