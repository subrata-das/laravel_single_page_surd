<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest​ extends FormRequest
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
            'full_name' => 'required|alpha_dash|max:80|min:3',
            'email' => 'required|email|max:80|min:3',
            'mobile' => 'required|numeric|digits:10',
            'country_code' => 'required|integer',
            'country_name' => '',
            'state_code' => 'required|integer',
            'state_name' => '',
            'city_code' => 'required|integer',
            'city_name' =>'',
            'avatar' => 'required|mimes:jpg,png,jpeg|max:2048|min:100'
        ];
    }
}
