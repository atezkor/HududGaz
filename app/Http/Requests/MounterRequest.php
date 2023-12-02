<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class MounterRequest extends FormRequest {
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
            'full_name' => ['required'],
            'short_name' => ['required'],
            'director' => ['required'],
            'tin' => ['required'],
            'rec_num' => ['required'],
            'reg_num' => ['required'],
            'district_id' => ['required'],
            'address' => ['required'],
            'given_by' => [],
            'date_registry' => ['required'],
            'date_expiry' => ['required'], // TODO greater_than
            'permissions' => [],
            'implementations' => [],
            'license' => []
        ];
    }

    public function attributes(): array {
        return [
            'full_name' => __('admin.mounter.full_name'),
            'short_name' => __('admin.mounter.short_name'),
            'director' => __('admin.mounter.director'),
            'rec_num' => __('admin.mounter.rec_num'),
            'reg_num' => __('admin.mounter.reg_num'),
            'district_id' => __('admin.mounter.district'),
            'address' => __('admin.mounter.address'),
            'tin' => __('admin.mounter.tin')
        ];
    }
}
