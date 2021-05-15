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
                'region' => ['required'],
                'address' => ['required']
            ];
        }

        return [
            'rec_num' => ['required'],
            'reg_num' => ['required'],
            'full_name' => ['required'],
            'short_name' => ['required'],
            'leader' => ['required'],
            'region' => ['required'],
            'address' => ['required'],
            'taxpayer_stir' => ['required'],
            'legal_form' => [],
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
          'leader' => __('table.mounters.leader'),
          'rec_num' => __('table.mounters.rec_num'),
          'reg_num' => __('table.mounters.reg_num'),
          'full_name' => __('table.mounters.full_name'),
          'short_name' => __('table.mounters.short_name'),
          'region' => __('table.mounters.region'),
          'address' => __('table.mounters.address'),
          'taxpayer_stir' => __('table.mounters.taxpayer_stir')
        ];
    }

    public function messages(): array {
        return [
            'date_created.email' => __('validation.date_invalid')
        ];
    }
}
