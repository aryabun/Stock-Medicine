<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqTransferRequest extends FormRequest
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
            // 'require_id',
            'user_id' => 'required|string',
            'from_warehouse' => 'required|string', //take ID
            'to_warehouse' => 'required|string', //Take ID
            'approve_by',
            'approve_date',
            'rejected_by',
            'rejected_date',
            'schedule_date',
            'eta',
            'status',
            'products' => ['nullable', 'array'],
            'products.*.product_code' => ['required', 'string', 'exists:products,product_code'],
            // 'products.*.request_id' => ['required', 'string', 'exists:re,product_code'],
        ];
    }
}
