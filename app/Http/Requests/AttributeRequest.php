<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            'id' => 'nullable|numeric',
            'campaign_id' => 'required|numeric',
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'field_description' => 'nullable|string|max:255',
        ];
    }
}