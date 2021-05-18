<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecommendationRequest extends FormRequest {
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
        $rules = [
            'accept' => $this->accept(),
            'fail' => $this->fail(),
        ];

        return [
            $rules[$this->input('type')]
        ];
    }

    private function accept(): array {
        return [
            'address' => ['required'],
            'access_point' => ['required'],
        ];
    }

    private function fail(): array {
        return [];
    }
}
