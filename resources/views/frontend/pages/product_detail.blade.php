@extends('frontend.layouts.master')
@section('title','PRODUCT DETAIL')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Shop Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Single -->
    <section class="shop single section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <!-- Product Slider -->
                            <div class="product-gallery">
                                <!-- Images slider -->
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">
                                        <li data-thumb="{{$product_detail->photo_url}}" rel="adjustX:10, adjustY:">
                                            <img src="{{$product_detail->photo_url}}">
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Images slider -->
                            </div>
                            <!-- End Product slider -->
                        </div>
                        {{--                        <div class="col-lg-6 col-12">--}}
                        {{--                            <div class="product-des">--}}
                        {{--                                <!-- Description -->--}}
                        {{--                                <div class="short">--}}
                        {{--                                    <h4>{{$product_detail->title}}</h4>--}}
                        {{--                                    <div class="rating-main">--}}
                        {{--                                        <ul class="rating">--}}
                        {{--                                            @php--}}
                        {{--                                                $rate=ceil($product_detail->getReview->avg('rate'))--}}
                        {{--                                            @endphp--}}
                        {{--                                            @for($i=1; $i<=5; $i++)--}}
                        {{--                                                @if($rate>=$i)--}}
                        {{--                                                    <li><i class="fa fa-star"></i></li>--}}
                        {{--                                                @else--}}
                        {{--                                                    <li><i class="fa fa-star-o"></i></li>--}}
                        {{--                                                @endif--}}
                        {{--                                            @endfor--}}
                        {{--                                        </ul>--}}
                        {{--                                        <a href="#" class="total-review">({{$product_detail['getReview']->count()}})--}}
                        {{--                                            Review</a>--}}
                        {{--                                    </div>--}}
                        {{--                                    @php--}}
                        {{--                                        $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));--}}
                        {{--                                    @endphp--}}
                        {{--                                    <p class="price"><span class="discount">${{number_format($after_discount,2)}}</span><s>${{number_format($product_detail->price,2)}}</s>--}}
                        {{--                                    </p>--}}
                        {{--                                    <p class="description">{!!($product_detail->summary)!!}</p>--}}
                        {{--                                </div>--}}
                        {{--                                <!--/ End Description -->--}}
                        {{--                                <!-- Color -->--}}
                        {{--                            --}}{{-- <div class="color">--}}
                        {{--                                <h4>Available Options <span>Color</span></h4>--}}
                        {{--                                <ul>--}}
                        {{--                                    <li><a href="#" class="one"><i class="ti-check"></i></a></li>--}}
                        {{--                                    <li><a href="#" class="two"><i class="ti-check"></i></a></li>--}}
                        {{--                                    <li><a href="#" class="three"><i class="ti-check"></i></a></li>--}}
                        {{--                                    <li><a href="#" class="four"><i class="ti-check"></i></a></li>--}}
                        {{--                                </ul>--}}
                        {{--                            </div> --}}
                        {{--                            <!--/ End Color -->--}}
                        {{--                                <!-- Size -->--}}
                        {{--                                @if($product_detail->size)--}}
                        {{--                                    <div class="size mt-4">--}}
                        {{--                                        <h4>Size</h4>--}}
                        {{--                                        <ul>--}}
                        {{--                                            @php--}}
                        {{--                                                $sizes=explode(',',$product_detail->size);--}}
                        {{--                                                // dd($sizes);--}}
                        {{--                                            @endphp--}}
                        {{--                                            @foreach($sizes as $size)--}}
                        {{--                                                <li><a href="#" class="one">{{$size}}</a></li>--}}
                        {{--                                            @endforeach--}}
                        {{--                                        </ul>--}}
                        {{--                                    </div>--}}
                        {{--                            @endif--}}
                        {{--                            <!--/ End Size -->--}}
                        {{--                                <!-- Product Buy -->--}}
                        {{--                                <div class="product-buy">--}}
                        {{--                                    <form action="{{route('single-add-to-cart')}}" method="POST">--}}
                        {{--                                        @csrf--}}
                        {{--                                        <div class="quantity">--}}
                        {{--                                            <h6>Quantity :</h6>--}}
                        {{--                                            <!-- Input Order -->--}}
                        {{--                                            <div class="input-group">--}}
                        {{--                                                <div class="button minus">--}}
                        {{--                                                    <button type="button" class="btn btn-primary btn-number"--}}
                        {{--                                                            disabled="disabled" data-type="minus" data-field="quant[1]">--}}
                        {{--                                                        <i class="ti-minus"></i>--}}
                        {{--                                                    </button>--}}
                        {{--                                                </div>--}}
                        {{--                                                <input type="hidden" name="slug" value="{{$product_detail->slug}}">--}}
                        {{--                                                <input type="text" name="quant[1]" class="input-number" data-min="1"--}}
                        {{--                                                       data-max="1000" value="1" id="quantity">--}}
                        {{--                                                <div class="button plus">--}}
                        {{--                                                    <button type="button" class="btn btn-primary btn-number"--}}
                        {{--                                                            data-type="plus" data-field="quant[1]">--}}
                        {{--                                                        <i class="ti-plus"></i>--}}
                        {{--                                                    </button>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                            <!--/ End Input Order -->--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="add-to-cart mt-4">--}}
                        {{--                                            <button type="submit" class="btn">Add to cart</button>--}}
                        {{--                                            <a href="{{route('add-to-wishlist',$product_detail->slug)}}"--}}
                        {{--                                               class="btn min"><i class="ti-heart"></i></a>--}}
                        {{--                                        </div>--}}
                        {{--                                    </form>--}}

                        {{--                                    <p class="cat">Category :<a--}}
                        {{--                                            href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>--}}
                        {{--                                    </p>--}}
                        {{--                                    @if($product_detail->sub_cat_info)--}}
                        {{--                                        <p class="cat mt-1">Sub Category :<a--}}
                        {{--                                                href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>--}}
                        {{--                                        </p>--}}
                        {{--                                    @endif--}}
                        {{--                                    <p class="availability">Stock : @if($product_detail->stock>0)<span--}}
                        {{--                                            class="badge badge-success">{{$product_detail->stock}}</span>@else <span--}}
                        {{--                                            class="badge badge-danger">{{$product_detail->stock}}</span>  @endif</p>--}}
                        {{--                                </div>--}}
                        {{--                                <!--/ End Product Buy -->--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <!-- Tab Nav -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Description Tab -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <p>{!! ($product_detail->description) !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Shop Single -->




@endsection
@push('styles')
    <style>
        /* Rating */
        .rating_box {
            display: inline-flex;
        }

        .star-rating {
            font-size: 0;
            padding-left: 10px;
            padding-right: 10px;
        }

        .star-rating__wrap {
            display: inline-block;
            font-size: 1rem;
        }

        .star-rating__wrap:after {
            content: "";
            display: table;
            clear: both;
        }

        .star-rating__ico {
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #F7941D;
            font-size: 16px;
            margin-top: 5px;
        }

        .star-rating__ico:last-child {
            padding-left: 0;
        }

        .star-rating__input {
            display: none;
        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover ~ .star-rating__ico:before,
        .star-rating__input:checked ~ .star-rating__ico:before {
            content: "\F005";
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
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
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
