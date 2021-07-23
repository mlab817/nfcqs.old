<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'office' => 'required|max:100',
            'full_name' => 'required|max:50',
            'email' => 'required|email|max:60|unique:users,email,'. $this->id,
            'password' => 'required|min:6',
            'password_confirmation' => 'same:password'
        ];
    }
}
