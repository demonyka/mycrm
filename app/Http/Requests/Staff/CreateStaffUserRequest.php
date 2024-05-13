<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @property string username
 * @property string password
 */
class CreateStaffUserRequest extends FormRequest
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
        $this->merge(['username' => strtolower($this->username)]);
        return [
            'username' => ['required', 'string', 'max:255', 'regex:/^[a-z\.]+$/i', 'unique:users'],
            'password' => 'required|string|min:8|max:64',
        ];
    }
}
