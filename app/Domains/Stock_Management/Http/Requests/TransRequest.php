<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransRequest extends FormRequest
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
            'contact_id' => 'required',
            'from_warehouse' => 'required',
            'to_warehouse' => 'required',
            'approved_by' => 'required',
            'approved_date' => 'required',
            'schedule_date',
            'eta',
            'status',
            'total_price',
            'products' => ['nullable', 'array'],
            'products.*.product_code' => ['required', 'string', 'exists:products,product_code'],
            'products.*.box_code' => ['required', 'string', 'exists:product_boxes,box_code'],
            // 'products.*.request_id' => ['required', 'string', 'exists:re,product_code'],
        ];
    }
}
