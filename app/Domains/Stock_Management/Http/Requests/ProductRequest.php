<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    public function rules(): array
    {
        // $product_code = optional($this->route('bottle'))->product_code;
        return [
            //
            'product_name' => 'required',
            'image' => '',
            'description' => '',
            'unit' => '',
            'strength' => '',
            'med_type' => '',
            'disease_type' => '',
            'status' => '',
            'prices' => ['nullable', 'array'],
            'variants' => ['nullable', 'array'],
        ];
    }
}
