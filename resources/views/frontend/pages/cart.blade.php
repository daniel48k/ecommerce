@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                        <tr class="main-hading">
                            <th>PRODUCT</th>
                            <th>NAME</th>
                            <th class="text-center">UNIT PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                        </thead>
                        <tbody id="cart_item_list">
                        <form action="{{route('cart.update')}}" method="POST">
                            @csrf
                            @if(getAllProductFromCart())
                                @foreach(getAllProductFromCart() as $key=>$cart)
                                    <tr>
                                        <td class="image" data-title="No">
                                            <img src="{{$cart->product->photo_url}}">
                                        </td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a
                                                    href="{{route('product-detail',$cart->product['id'])}}"
                                                    target="_blank">{{$cart->product['title']}}</a></p>
                                            <p class="product-des">{!!($cart['description']) !!}</p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <span>${{number_format($cart->product['price'],2)}}</span></td>
                                        <td class="qty" data-title="Qty">
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                            @if($cart->quantity==1)
                                                            disabled="disabled"
                                                            @endif
                                                            data-type="minus"
                                                            data-field="quant[{{$key}}]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{$key}}]" class="input-number"
                                                       data-min="1" data-max="100" value="{{$cart->quantity}}">
                                                <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[{{$key}}]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-amount cart_single_price" data-title="Total"><span
                                                class="money">${{$cart->amount}}</span></td>

                                        <td class="action" data-title="Remove"><a
                                                href="{{route('cart-delete',$cart->id)}}"><i
                                                    class="ti-trash remove-icon"></i></a></td>
                                    </tr>
                                @endforeach
                                <track>
                                <td class="float-right">
                                    <button class="btn float-right" type="submit">Update</button>
                                </td>
                                </track>
                            @else
                                <tr>
                                    <td class="text-center">
                                        There are no any carts available. <a href="{{route('shop.filter')}}"
                                                                             style="color:blue;">Continue shopping</a>
                                    </td>
                                </tr>
                            @endif
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{totalCartPrice()}}">
                                            Cart Subtotal
                                            <span>${{number_format(totalCartPrice(),2)}}
                                            </span></li>
                                        <div id="shipping" style="display:none;">
                                            <li class="shipping">Shipping
                                                <div class="form-select">
                                                    <span>Free</span>
                                                </div>
                                            </li>
                                        </div>
                                        @php
                                            $total_amount=totalCartPrice();
                                        @endphp
                                    </ul>
                                    <div class="button5">
                                        @if(getAllProductFromCart())
                                            <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                        @endif
                                        <a href="{{route('shop.filter')}}" class="btn">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>


@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>

@endpush
