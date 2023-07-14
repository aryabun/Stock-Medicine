<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductBoxRequest extends FormRequest
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
            'product_code' => 'sometimes|required',
            'lot_code' => 'sometimes|required',
            'bottle_qty' => 'sometimes|required',
            'exp_date' => 'sometimes|required',
            'qty_per_bottle',
            'unit',
        ];
    }
}
