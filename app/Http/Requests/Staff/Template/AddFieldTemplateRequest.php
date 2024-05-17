<?php

namespace App\Http\Requests\Staff\Template;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string slug
 * @property string type
 * @property bool hidden
 * @property bool required
 */
class AddFieldTemplateRequest extends FormRequest
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
        $this->merge(['hidden' => filter_var($this->hidden, FILTER_VALIDATE_BOOLEAN)]);
        $this->merge(['required' => filter_var($this->required, FILTER_VALIDATE_BOOLEAN)]);
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'slug' => ['required', 'string', 'min:2', 'max:255'],
            'type' => ['required', 'string'],
            'hidden' => ['required', 'bool'],
            'required' => ['required', 'bool'],
        ];
    }
}
