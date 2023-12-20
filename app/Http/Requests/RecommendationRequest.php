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
            'reject' => $this->reject(),
        ];

        return $rules[$this->input('type')];
    }

    public function attributes(): array {
        return [
            'address' => __('organ.recommendation.address'),
            'access_point' => __('organ.recommendation.access_point'),
            'description' => __('organ.recommendation.description'),
            'additional' => __('organ.recommendation.additional')
        ];
    }

    private function accept(): array {
        return [
            'proposition_id' => ['required'],
            'type' => ['required'], // Action type
            'address' => ['required'],
            'access_point' => ['required'],
            'gas_network' => ['required'],
            'pipeline' => [],
            'pipe_type' => [],
            'length' => [],
            'pipe1' => [],
            'depth' => [],
            'capability' => [],
            'pressure_win' => [],
            'pressure_sum' => [],
            'grc' => [],
            'consumption' => [],
            'additional' => [],
            'equipments' => [],
            'pdf' => []
        ];
    }

    private function reject(): array {
        return [
            'proposition_id' => ['required'],
            'type' => ['required'], // Action type
            'description' => ['required'],
            'additional' => ['required'],
            'pdf' => []
        ];
    }
}
