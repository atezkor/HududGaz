<?php

namespace App\Http\Requests;

use App\Models\Application;
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
            Application::PHYSICAL => $this->individual(),
            Application::LEGAL => $this->legal()
        ];

        return $rules[(int)$this->input('type')];
    }

    public function attributes(): array {
        return [
            'number' => __('global.proposition.number'),
            'pin_fl' => __('technic.applicant.pin_fl'),
            'passport' => __('technic.applicant.passport'),
            'name' => $this->get('type') == Application::PHYSICAL ? __('technic.applicant.name') : __('technic.applicant.legal_name'),
            'surname' => __('technic.applicant.surname'),
            'tin' => __('technic.applicant.legal_tin'),
            'director' => __('technic.applicant.director'),
            'director_pin_fl' => __('technic.applicant.director_pin_fl'),
            'email' => __('technic.applicant.email'),
            'phone' => __('technic.applicant.phone'),
            'activity_type_id' => __('technic.proposition.activity_type'),
            'organization_id' => __('technic.proposition.organ')
        ];
    }

    private function individual(): array {
        return [
            'number' => ['required'],
            'organization_id' => ['required'],
            'build_type' => [],
            'type' => ['required'],
            'status' => [],
            'pdf' => [],
            'delete_at' => [],

            // Applicant
            'proposition_id' => [],
            'name' => ['required'],
            'surname' => ['required'],
            'phone' => ['required'],
            'passport' => ['required'],
            'pin_fl' => ['required', 'numeric']
        ];
    }

    private function legal(): array {
        return [
            'number' => ['required'],
            'organization_id' => ['required'],
            'activity_type_id' => ['required'],
            'build_type' => [],
            'type' => ['required'],
            'status' => [],
            'pdf' => [],
            'delete_at' => [],

            // Applicant
            'proposition_id' => [],
            'tin' => ['required'],
            'name' => ['required'],
            'email' => ['required'],
            'director' => ['required'],
            'director_pin_fl' => ['required'],
            'phone' => ['required']
        ];
    }
}
