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
            'org_number' => ['required'],
            'lead_engineer' => ['required'],
            'section_leader' => ['required'],
            'region' => ['required'],
            'org_name' => ['required'],
            'address' => ['required'],
            'address_krill' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'fax' => []
        ];
    }

    public function attributes(): array {
        return [
            'org_number' => __('table.districts.org_num'),
            'lead_engineer' => __('table.districts.engineer'),
            'section_leader' => __('table.districts.section_leader'),
            'region' => __('table.districts.region'),
            'org_name' => __('table.general.org_name'),
            'address' => __('table.districts.address'),
            'address_krill' => __('table.districts.address_krill'),
            'email' => __('table.districts.email'),
            'phone' => __('table.general.phone')
        ];
    }
}
