<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed avatar
 * @property string password
 * @property int template_id
 */
class EditMainStaffUserRequest extends FormRequest
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
            'avatar' => 'nullable|file|max:10240|mimes:jpeg,png',
            'password' => 'nullable|string|min:8|max:64',
            'template_id' => 'nullable|integer'
        ];
    }
}
