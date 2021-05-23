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

        return $rules[$this->input('type')];
    }

    public function attributes(): array {
        return [
            'address' => __('district.recommendation.address'),
            'access_point' => __('district.recommendation.access_point'),
            'description' => __('district.recommendation.description'),
            'additional' => __('district.recommendation.additional')
        ];
    }

    private function accept(): array {
        return [
            'proposition_id' => ['required'],
            'address' => ['required'],
            'access_point' => ['required'],
            'above_len' => [],
            'under_len' => [],
            'diameter' => [],
            'depth' => [],
            'capability' => [],
            'real_capacity' => [],
            'pressure_win' => [],
            'pressure_sum' => [],
            'grc' => [],
            'consumption' => [],
            'additional' => [],
            'type' => ['required']
        ];
    }

    private function fail(): array {
        return [
            'proposition_id' => ['required'],
            'description' => ['required'],
            'additional' => ['required'],
            'type' => ['required']
        ];
    }
}
