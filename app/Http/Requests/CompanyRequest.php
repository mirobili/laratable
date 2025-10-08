<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'irs_id' => ['required', 'string', 'max:50', 'unique:companies,irs_id'],
            'stamp' => ['nullable', 'string', 'max:255'],
            'meta_data' => ['nullable', 'array'],
            'contact_info' => ['nullable', 'array'],
        ];

        // For update requests
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['irs_id'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('companies', 'irs_id')->ignore($this->company)
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required',
            'irs_id.required' => 'The tax identification number is required',
            'irs_id.unique' => 'This tax identification number is already in use',
        ];
    }
}
