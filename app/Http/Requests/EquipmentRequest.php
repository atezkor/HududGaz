<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest {
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
        /* For equipment types */
        if ($this->request->has('type')) {
            return [
                'type' => ['required'],
                'order' => ['required']
            ];
        }

        return [
            'name' => ['required']
        ];
    }

    public function attributes(): array {
        return [
            'name' => __('admin.equipment.name'),
            'type' => __('admin.equipment.equip_type'),
            'order' => __('admin.equipment.equip_order')
        ];
    }
}
