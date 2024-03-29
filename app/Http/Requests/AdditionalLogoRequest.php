<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalLogoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'additionalLogo' => 'required|mimes:jpeg,jpg,png,svg|max:10000',
        ];
    }


    public function attributes()
    {
        return [
            'additionalLogo' => 'Logo',
        ];
    }
}
