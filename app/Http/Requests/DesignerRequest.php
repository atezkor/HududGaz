<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class DesignerRequest extends FormRequest {
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
            'director' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'address_krill' => [],
            'registry_date' => [], // TODO greater than
            'expiry_date' => [],
            'license' => [$this->get('id') ? "" : 'required']
        ];
    }

    public function attributes(): array {
        return [
            'name' => __('admin.org_name'),
            'director' => __('admin.org_director'),
            'phone' => __('admin.phone'),
            'address' => __('admin.address'),
            'license' => __("admin.document")
        ];
    }
}
