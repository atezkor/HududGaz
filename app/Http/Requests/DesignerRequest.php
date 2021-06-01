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
        if ($this->request->get('date_reg') >= $this->request->get('date_end')) {
            return [
                'date_reg' => ['email'],
                'org_name' => ['required'],
                'leader' => ['required'],
                'phone' => ['required'],
                'address' => ['required']
            ];
        }

        return [
            'org_name' => ['required'],
            'leader' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'address_krill' => [],
            'date_reg' => [],
            'date_end' => [],
            'document' => []
        ];
    }

    public function attributes(): array {
        return [
          'phone' => __('admin.phone'),
          'org_name' => __('admin.org_name'),
          'leader' => __('admin.org_leader'),
          'address' => __('admin.address')
        ];
    }

    public function messages(): array {
        return [
            'date_reg.email' => __('validation.date_invalid')
        ];
    }
}
