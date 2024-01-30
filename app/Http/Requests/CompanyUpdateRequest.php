<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('companies')->ignoreModel($this->company),
            ],
            'logo' => ['image', 'mimes:png,jpg,jpeg', 'dimensions:min_width=100,min_height=100'],
            'website' => ['url', 'max:255'],
        ];
    }
}
