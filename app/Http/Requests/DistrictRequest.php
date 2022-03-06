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
            'district' => ['required'],
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
            'org_number' => __('admin.organ.org_num'),
            'lead_engineer' => __('admin.organ.engineer'),
            'section_leader' => __('admin.organ.section_leader'),
            'region' => __('admin.organ.select_hint'),
            'org_name' => __('admin.org_name'),
            'address' => __('admin.organ.address'),
            'address_krill' => __('admin.organ.address_krill'),
            'email' => __('admin.organ.email'),
            'phone' => __('admin.phone')
        ];
    }
}
