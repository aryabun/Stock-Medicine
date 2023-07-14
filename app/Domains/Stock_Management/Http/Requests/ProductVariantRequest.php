<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            '*.product_code'  =>'required',
            '*.attribute_id' =>'required|integer', 
            '*.value_id' =>'required|integer', 
            // 'created_by' =,
        ];
    }
}
