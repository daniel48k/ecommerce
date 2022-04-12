@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add SubCategory</h5>
        <div class="card-body">
            <form method="post" action="{{route('sub_category.store')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach($categories as $key=>$data)
                            <option value='{{$data->id}}'>{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter title" value="{{old('name')}}"
                           class="form-control">
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>




                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
