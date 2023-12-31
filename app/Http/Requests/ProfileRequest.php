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
        // $hasPass = $this->input('password_old') || $this->input('password') || $this->input('password_confirm');
        $hasPass = $this->input('pass');

        if ($hasPass) {
            $pass = $this->input('password');
            $passConfirm = $this->input('password_confirm');
            if ($pass != $passConfirm) {
                return [
                    'password_old' => ['required'],
                    'password' => ['required'],
                    'password_confirm' => ['required', 'confirmed']
                ];
            }

            return [
                'password_old' => ['required'],
                'password' => ['required', 'min:6'],
                'password_confirm' => ['required', 'min:6']
            ];
        }

        return [
            'username' => ['required'],
            'name' => ['required'],
            'lastname' => ['required'],
            'patronymic' => [],
            'position' => [],
            'locale' => [],
            'avatar' => []
        ];
    }

    public function attributes(): array {
        return [
            'username' => __('global.profile.username'),
            'name' => __('global.profile.name'),
            'lastname' => __('global.profile.lastname'),
            'password_old' => __('global.profile.pass_old'),
            'password' => __('global.profile.password'),
            'password_confirm' => __('global.profile.pass_confirm')
        ];
    }
}
