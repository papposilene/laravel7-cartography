<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddress extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->can('update')) {
            return true;
        }
		
		return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_uuid' => 'required|uuid',
            'address_name' => 'string|required|max:255',
            'address_owner' => 'string|nullable|max:255',
            'address_address' => 'string|required',
            'address_status' => 'boolean|required',
            'address_description' => 'string|nullable',
            'address_phone' => 'string|nullable|max:255',
            'address_url' => 'url|nullable|max:255',
            'address_latlng' => 'string|required|max:255',
            'category_uuid' => 'uuid|required',
            'country_uuid' => 'uuid|required',
        ];
    }
}
