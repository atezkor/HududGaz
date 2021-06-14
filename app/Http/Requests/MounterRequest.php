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
        if ($this->request->get('date_created') >= $this->request->get('date_expired')) {
            return [
                'date_created' => ['email'],
                'short_name' => ['required'],
                'leader' => ['required'],
                'district' => ['required'],
                'address' => ['required']
            ];
        }

        return [
            'rec_num' => ['required'],
            'reg_num' => ['required'],
            'full_name' => ['required'],
            'short_name' => ['required'],
            'leader' => ['required'],
            'district' => ['required'],
            'address' => ['required'],
            'taxpayer_stir' => ['required'],
            'given_by' => [],
            'date_created' => ['required'],
            'date_expired' => ['required'],
            'permission_to' => [],
            'implement_for' => [],
            'document' => []
        ];
    }

    public function attributes(): array {
        return [
          'leader' => __('admin.mounter.leader'),
          'rec_num' => __('admin.mounter.rec_num'),
          'reg_num' => __('admin.mounter.reg_num'),
          'full_name' => __('admin.mounter.full_name'),
          'short_name' => __('admin.mounter.short_name'),
          'district' => __('admin.mounter.district'),
          'address' => __('admin.mounter.address'),
          'taxpayer_stir' => __('admin.mounter.taxpayer_stir')
        ];
    }

    public function messages(): array {
        return [
            'date_created.email' => __('validation.date_invalid')
        ];
    }
}
