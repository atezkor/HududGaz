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
        return [
            'firm_id' => ['required'],
            'statement_number' => [],
            'first_name' => [],
            'second_name' => [],
            'last_name' => [],
            'date_contract' => [],
            'date_contract_end' => [],
            'diploma_number' => [],
            'passport_series' => [],
            'specialization' => [],
            'function' => [],
            'experience' => [],
            'document' => []
        ];
    }
}
