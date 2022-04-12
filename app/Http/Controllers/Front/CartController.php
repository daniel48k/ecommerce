<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**@var CartRepository */
    protected $cartRepository;

    /**@var ProductRepository */
    protected $productRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function getCart()
    {
        return view('frontend.pages.cart');
    }

    public function singleAddToCart(Request $request, $id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $this->cartRepository->addToCart($request, $product, 1);

        request()->session()->flash('success', 'Product successfully added to cart');
        return back();
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quant' => 'required',
        ]);

        $product = $this->productRepository->find($request->id);

        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $this->cartRepository->addToCart($request, $product, $request->quant[1]);

        request()->session()->flash('success', 'Product successfully added to cart.');
        return back();
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success', 'Cart successfully removed');
            return back();
        }
        request()->session()->flash('error', 'Error please try again');
        return back();
    }

    public function cartUpdate(Request $request)
    {
        if ($request->quant) {
            $error = array();
            $success = '';

            foreach ($request->quant as $k => $quant) {
                $id = $request->qty_id[$k];
                $cart = $this->cartRepository->find($id);

                if ($quant > 0 && $cart) {
                    $input['quantity'] = $quant;
                    $this->cartRepository->update($input, $id);
                    $success = 'Cart successfully updated!';
                }
            }
            return back()->with('success', $success);
        } else {
            return back()->with('Cart Invalid!');
        }
    }

    public function checkout()
    {
        auth()->user()->carts()->delete();
        return redirect(route('home'))->with('success', 'You have made a successful checkout');
    }
}
