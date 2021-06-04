<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest {
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
        if ($this->input('password') != $this->input('password') &&
            ($this->input('old_pass') && $this->input('password') && $this->input('confirm_pass')))
            return [
                "old_pass" => ['email']
            ];

        if ($this->input('old_pass') || $this->input('password') || $this->input('confirm_pass'))
            return [
                "password" => ['required', 'min:6'],
                "old_pass" => ['required'],
                "confirm_pass" => ['required', 'min:6']
            ];

        return [
            'username' => ['required'],
            'name' => ['required'],
            'lastname' => ['required'],
            "patronymic" => [],
            "position" => [],
            "locale" => [],
            'avatar' => []
        ];
    }

    public function attributes(): array {
        return [
            'username' => __('global.profile.username'),
            'name' => __('global.profile.name'),
            'lastname' => __('global.profile.lastname'),
            'password' => __('global.profile.password'),
            'old_pass' => __('global.profile.old_pass'),
            'confirm_pass' => __('global.profile.confirm_pass')
        ];
    }

    public function messages(): array {
        return [
            'old_pass.email' => __('global.profile.not_confirm')
        ];
    }
}
