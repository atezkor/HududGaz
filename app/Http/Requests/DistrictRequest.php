<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest {
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
            'org_number' => [],
            'lead_engineer' => [],
            'section_leader' => [],
            'region' => [],
            'org_name' => [],
            'address_latin' => [],
            'address' => [],
            'email' => [],
            'phone' => [],
            'fax' => []
        ];
    }
}
