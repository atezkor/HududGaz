<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropositionRequest extends FormRequest {
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
            1 => $this->individual(),
            2 => $this->legal()
        ];

        return $rules[(int) $this->input('type')];
    }

    public function attributes(): array {
        return [
            'number' => __('technic.prop_num'),
            'stir' => __('technic.propositions.stir'),
            'passport' => __('technic.propositions.passport'),
            'full_name' => __('technic.propositions.full_name'),
            'legal_stir' => __('technic.propositions.legal_stir'),
            'legal_name' => __('technic.propositions.legal_name'),
            'leader' => __('technic.propositions.leader'),
            'leader_stir' => __('technic.propositions.leader_stir'),
            'email' => __('technic.propositions.email'),
            'activity_type' => __('technic.propositions.activity_type'),
            'district' => __('technic.propositions.district'),
            'phone' => __('technic.propositions.phone')
        ];
    }

    private function individual(): array {
        return [
            'number' => ['required'],
            'district' => ['required'],
            'activity_type' => ['required'],
            'build_type' => [],
            'type' => ['required'],
            'status' => [],
            'file' => [],
            'delete_at' => [],

            'proposition_id' => [],
            'full_name' => ['required'],
            'phone' => ['required'],
            'passport' => ['required'],
            'stir' => ['required']
        ];
    }

    private function legal(): array {
        return [
            'number' => ['required'],
            'district' => ['required'],
            'activity_type' => ['required'],
            'build_type' => [],
            'type' => ['required'],
            'status' => [],
            'file' => [],
            'delete_at' => [],

            'proposition_id' => [],
            'legal_stir' => ['required'],
            'legal_name' => ['required'],
            'email' => ['required'],
            'leader' => ['required'],
            'leader_stir' => ['required'],
            'phone' => ['required']
        ];
    }
}
