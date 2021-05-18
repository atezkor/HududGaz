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
            'number' => __('global.proposition.number'),
            'stir' => __('technic.proposition.stir'),
            'passport' => __('technic.proposition.passport'),
            'full_name' => __('technic.proposition.full_name'),
            'legal_stir' => __('technic.proposition.legal_stir'),
            'legal_name' => __('technic.proposition.legal_name'),
            'leader' => __('technic.proposition.leader'),
            'leader_stir' => __('technic.proposition.leader_stir'),
            'email' => __('technic.proposition.email'),
            'activity_type' => __('technic.proposition.activity_type'),
            'organ' => __('technic.proposition.organ'),
            'phone' => __('technic.proposition.phone')
        ];
    }

    private function individual(): array {
        return [
            'number' => ['required'],
            'organ' => ['required'],
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
            'organ' => ['required'],
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
