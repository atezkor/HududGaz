<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FitterRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        if ($this->request->get('date_contract') >= $this->request->get('date_contract_end')) {
            return [
                'date_contract' => ['email']
            ];
        }

        return [
            'firm_id' => ['required'],
            'statement_number' => [],
            'first_name' => ['required'],
            'second_name' => ['required'],
            'last_name' => ['required'],
            'date_contract' => ['required'],
            'date_contract_end' => ['required'],
            'diploma_number' => ['required'],
            'passport_series' => ['required'],
            'specialization' => ['required'],
            'experience' => [],
            'document' => []
        ];
    }

    public function attributes(): array {
        return [
            'first_name' => __('table.mounters.first_name'),
            'second_name' => __('table.mounters.second_name'),
            'last_name' => __('table.mounters.last_name'),
            'diploma_number' => __('table.mounters.diploma_number'),
            'passport_series' => __('table.mounters.passport_series'),
            'specialization' => __('table.mounters.specialized')
        ];
    }

    public function messages(): array {
        return [
            'date_contract.email' => __('validation.date_invalid'),
            'firm_id.required' => __('table.mounters.firm')
        ];
    }
}
