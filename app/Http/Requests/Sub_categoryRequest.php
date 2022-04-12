<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Sub_categoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required'
        ];
    }
}
