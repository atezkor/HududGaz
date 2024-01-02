<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TechConditionRequest extends FormRequest {
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
            'description' => [],
            'content' => ['required']
        ];
    }

    public function attributes(): array {
        return [
            'content' => __('technic.tech_condition.ref')
        ];
    }
}
