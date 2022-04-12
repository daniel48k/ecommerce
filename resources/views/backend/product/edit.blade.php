@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Product</h5>
        <div class="card-body">
            <form method="post" action="{{route('products.update',$product->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                           value="{{$product->title}}" class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description"
                              name="description">{{$product->description}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach($categories as $key=>$cat_data)
                            @if($cat_data->id==$product->sub_category->category_id)
                                <option selected
                                        value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->name}}</option>
                            @else
                                <option
                                    value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->name}}</option>
                            @endif

                        @endforeach
                    </select>
                </div>

                <div class="form-group {{(($product->sub_category_id)? '' : 'd-none')}}" id="child_cat_div">
                    <label for="sub_category_id">Sub Category</label>
                    <select name="sub_category_id" id="sub_category_id" class="form-control">
                        <option value="">--Select any sub category--</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price" value="{{$product->price}}"
                           class="form-control">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group d-flex align-items-center">
              <span class="input-group-btn">
                  <img src="{{$product->photo_url}}" alt="" height="100px" width="100px">
              </span>
                        <input type="file" name="photo" class="form-control-file" id="photo">
                    </div>
                    @error('photo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>

@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script>
        var child_cat_id = '{{$product->sub_category_id}}';
        // alert(child_cat_id);
        $('#category_id').change(function () {
            var category_id = $(this).val();

            if (category_id != null) {
                // ajax call
                $.ajax({
                    url: "/admin/api/categories/" + category_id + "/sub_categories",
                    type: "GEt",
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (typeof (response) != 'object') {
                            response = $.parseJSON(response);
                        }
                        var html_option = "<option value=''>--Select any one--</option>";
                        if (response.status) {
                            var data = response.data;
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                data.forEach(function (val, index, theArray) {
                                    html_option += "<option value='" + val.id + "' " + (child_cat_id == val.id ? 'selected ' : '') + ">" + val.name + "</option>";

                                    // html_option += "<option value='" + val.id +(child_cat_id == id ? 'selected ' : '')+ "'>" + val.name + "</option>"
                                });
                                // $.each(data, function (id, name) {
                                //     html_option += "<option value='" + id + "' " + (child_cat_id == id ? 'selected ' : '') + ">" + name + "</option>";
                                // });
                            } else {
                                console.log('no response data');
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#sub_category_id').html(html_option);

                    }
                });
            } else {

            }

        });
        if (child_cat_id != null) {
            $('#category_id').change();
        }
    </script>
@endpush
