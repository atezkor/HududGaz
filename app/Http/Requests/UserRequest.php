<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    public function attributes(): array {
        return [
            'name' => __('admin.user.name'),
            'role' => __('admin.user.role'),
            'email' => __('admin.user.email'),
            'password' => __('admin.user.password')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['required'],
            'lastname' => [],
            'patronymic' => [],
            'role' => ['required'],
            'organ' => [],
            'email' => ['required',
                Rule::unique('users', 'email')->ignore($this->route('user'))
            ],
            'password' => ['required', 'min:6'],
            'locale' => [],
            'position' => [],
            'mac_address' => []
        ];
    }

    public function messages(): array {
        return [
            'email.unique' => __('admin.user.uniq_login')
        ];
    }
}
