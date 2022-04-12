@extends('frontend.layouts.master')

@section('title','Products')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="#">Shop Grid</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Product Style -->
    <form action="{{route('shop.filter')}}" method="GET">
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @php
                                        $menu=availableCategoriesWithProducts();
                                    @endphp
                                    @if($menu)
                                        <li>
                                        @foreach($menu as $cat_info)
                                            @if($cat_info->sub_categories->count()>0)
                                                <li>
                                                    <a class="{{($cat_info->id==request()->query('category'))?'category_active':''}}"
                                                       href="{{route('shop.filter',shopFilterQueryReplacer(['category'=>$cat_info->id],request()->all()))}}">{{$cat_info->name}}</a>
                                                    <ul>
                                                        @foreach($cat_info->sub_categories as $sub_menu)
                                                            <li>
                                                                <a class="{{($sub_menu->id==request()->query('sub_category'))?'category_active':''}}"
                                                                   href="{{route('shop.filter',shopFilterQueryReplacer(['sub_category'=>$sub_menu->id],request()->all()))}}">{{$sub_menu->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="{{($cat_info->id==request()->query('category'))?'category_active':''}}"
                                                       href="{{route('shop.filter',shopFilterQueryReplacer(['category'=>$cat_info->id],request()->all()))}}">{{$cat_info->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            @if(!empty($_GET['sub_category']))
                                <input type="hidden" name="sub_category" value="{{$_GET['sub_category']}}"/>
                            @endif
                            @if(!empty($_GET['category']))
                                <input type="hidden" name="category" value="{{$_GET['category']}}"/>
                            @endif

                            <div class="single-widget range">
                                <h3 class="title">Shop by Price</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        <div id="slider-range" data-min="0" data-max="{{$max_price}}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter_button">Filter</button>
                                            <div class="label-input">
                                                <span>Range:</span>
                                                <input style="" type="text" id="amount" readonly/>
                                                <input type="hidden" name="price_range" id="price_range"
                                                       value="@if(!empty($_GET['price_range'])){{$_GET['price_range']}}@endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">

                                <div class="shop-top  align-items-center">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>
                                                    09
                                                </option>
                                                <option value="15"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>
                                                    15
                                                </option>
                                                <option value="21"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>
                                                    21
                                                </option>
                                                <option value="30"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>
                                                    30
                                                </option>
                                            </select>
                                        </div>

                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>
                                                    Name
                                                </option>
                                                <option value="price"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>
                                                    Price
                                                </option>
                                            </select>
                                        </div>

                                        <div style="float:right;margin-left: auto">
                                            <a class="reset_button btn" href="{{route('shop.filter')}}">
                                                Reset Filters
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($products)>0)
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail',$product->id)}}">
                                                    <img class="default-img" src="{{$product->photo_url}}">
                                                    <img class="hover-img" src="{{$product->photo_url}}">
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{$product->id}}"
                                                           title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart"
                                                           href="{{route('add-to-cart',$product->id)}}">Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3>
                                                    <a href="{{route('product-detail',$product->id)}}">{{$product->title}}</a>
                                                </h3>
                                                <span>${{number_format($product->price,2)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                            @endif

                        </div>

                        <div class="row">
                            <div class="col-md-12 justify-content-center">
                                {{$products->appends($_GET)->links()}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </form>

    <!--/ End Product Style 1  -->



    <!-- Modal -->
    @if($products)
        @foreach($products as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        {{--                                        <div class="quickview-slider-active">--}}
                                        <img src="{{$product->photo_url}}">
                                        {{--                                        </div>--}}
                                    </div>
                                    <!-- End Product slider -->
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <h3>
                                            ${{number_format($product->price,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{{$product->description}}</p>
                                        </div>

                                        <form action="{{route('single-add-to-cart')}}" method="POST">
                                            @csrf
                                            <div class="quantity">
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{$product->id}}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                           data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->

@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
                    else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function () {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function (event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush
<style>
    .category_active {
        color: #F7941D !important;
    }

    .reset_button {
        height: 27px !important;
        text-align: center !important;
        background: #F7941D !important;
        padding-top: 0px!important;
        padding-bottom: 0px!important;
        color: white;
    }
</style>
