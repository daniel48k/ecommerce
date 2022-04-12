<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sub_category_id'=>'required',
            'title'=>'required',
            'description'=>'required',
            'price'=>'required',
            'photo'=>'required|image|mimes:jpeg,jpg,png,bmp,gif,svg'
        ];
    }
}
