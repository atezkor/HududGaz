<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MounterRequest extends FormRequest {
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
            'rec_num' => [],
            'reg_num' => [],
            'full_name' => [],
            'short_name' => [],
            'leader' => [],
            'region' => [],
            'address' => [],
            'taxpayer_stir' => [],
            'legal_form' => [],
            'given_by' => [],
            'date_created' => [],
            'date_expired' => [],
            'permission_to' => [],
            'implement_for' => [],
            'document' => []
        ];
    }
}
