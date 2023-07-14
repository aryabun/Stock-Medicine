<?php

namespace App\Domains\Stock_Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'hospital_id' ,
            'level' ,
            'province_id' ,
            'district_id' ,
            'commune_id' ,
            'village_id' ,
            'address' ,
            // 'products.*.request_id' => ['required', 'string', 'exists:re,product_code'],
        ];
    }
}
