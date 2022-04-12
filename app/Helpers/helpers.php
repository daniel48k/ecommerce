<?php

if (!function_exists('getAllProductFromCart')) {
    function getAllProductFromCart()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user_id = auth()->user()->id;
            $carts = \App\Models\Cart::with('product')->where('client_id', $user_id)->count();
            if ($carts == 0) return 0;
            return \App\Models\Cart::with('product')->where('client_id', $user_id)->get();
        } else {
            return 0;
        }
    }
}

if (!function_exists('totalCartPrice')) {
    function totalCartPrice()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user_id = auth()->user()->id;
            return \App\Models\Cart::where('client_id', $user_id)->sum(\Illuminate\Support\Facades\DB::raw('carts.quantity * carts.price'));
        } else {
            return 0;
        }
    }
}

if (!function_exists('shopFilterQueryReplacer')) {
    function shopFilterQueryReplacer($newQuery, $oldQuery)
    {
        $query = $oldQuery;
        if (in_array('sub_category', array_keys($newQuery))&&!empty($newQuery['sub_category'])) {
            unset($query['category']);
            $query=array_merge($query,$newQuery);
        } elseif (in_array('category', array_keys($newQuery))&&!empty($newQuery['category'])) {
            unset($query['sub_category']);
            $query=array_merge($query,$newQuery);
        }
        return $query;
    }
}


if (!function_exists('availableCategoriesWithProducts')) {
    function availableCategoriesWithProducts()
    {
        return \App\Models\Category::get();
    }
}
