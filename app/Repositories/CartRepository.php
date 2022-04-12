<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class CartRepository
 * @package App\Repositories
 * @version June 19, 2021, 1:21 pm UTC
 */
class CartRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'client_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cart::class;
    }

    public function getPrice($cart)
    {
        return $cart->price;
    }

    public function addToCart($request, Product $product,$qty)
    {
        $cart = $this->model->newQuery()->where('client_id', auth()->user()->id)->where('product_id', $product->id)->first();

        if ($cart) {
            $cart->quantity += $qty;
            $cart->save();
        } else {
            $cart = new Cart;
            $cart->client_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price;
            $cart->quantity = $qty;
            $cart->save();
        }
        return $cart;
    }

}
