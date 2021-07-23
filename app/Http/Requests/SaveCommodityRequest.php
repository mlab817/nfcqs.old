<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCommodityRequest extends FormRequest
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

    public function prepareForValidation()
    {

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commodity_id'      => 'required|exists:src_commodities,id',
            'conversion_rate'   => 'required|numeric|min:0|max:100',
            'province_id'       => 'required|exists:src_provinces,id',
            'population'        => 'required|integer',
            'year'              => 'required|integer|min:1900|max:'.date('Y'),
            'per_capita'        => 'required|numeric|min:0',
            'per_capita_year'   => 'required|numeric|min:1900|max:'.date('Y'),
            'commodity_data'    => 'required|mimes:csv,txt',
            'pop_growth_rate'   => 'required|mimes:csv,txt'
        ];
    }
}
