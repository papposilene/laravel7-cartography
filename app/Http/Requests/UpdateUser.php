<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'user_uuid' => 'required|uuid',
            'user_uname' => 'required|string|unique:users,uname|max:255',
            'user_fname' => 'nullable|string|max:255',
            'user_mname' => 'nullable|string|max:255',
            'user_lname' => 'nullable|string|max:255',
            'user_email' => 'required|email|unique:users,email|max:255',
            'user_password' => 'required|alpha_dash|min:8',
        ];
    }
}
