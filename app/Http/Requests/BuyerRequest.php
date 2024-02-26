<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerRequest extends FormRequest
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
            'id' => 'numeric',
            'campaign_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'buyer_name' => 'required|string|max:255',
            'buyer_nickname' => 'nullable|string|max:255',
            'requests' => 'required|numeric'
        ];
    }
}