<?php

namespace App\Http\Requests\Staff\Template;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 */
class CreateStaffTemplateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:staff_templates'],
        ];
    }
}
