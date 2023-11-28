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
            'name' => ['required'],
            'tin' => ['required'],
            'lead_engineer' => ['required'],
            'department_head' => ['required'],
            'district_id' => ['required'],
            'address' => ['required'],
            'address_krill' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'fax' => []
        ];
    }

    public function attributes(): array {
        return [
            'name' => __('admin.org_name'),
            'tin' => __('admin.organ.org_num'),
            'lead_engineer' => __('admin.organ.engineer'),
            'department_head' => __('admin.organ.department_head'),
            'district_id' => __('admin.organ.select_hint'),
            'address' => __('admin.organ.address'),
            'address_krill' => __('admin.organ.address_krill'),
            'email' => __('admin.organ.email'),
            'phone' => __('admin.phone')
        ];
    }
}
