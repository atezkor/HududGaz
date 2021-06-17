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
            'username' => __('admin.user.username'),
            'password' => __('admin.user.password'),
            'lastname' => __('admin.user.lastname')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        $pass = [
            'POST' => ['required', 'min:6'],
            'PUT' => []
        ];

        return [
            'name' => ['required'],
            'lastname' => ['required'],
            'patronymic' => [],
            'role' => ['required'],
            'organ' => [],
            'username' => ['required',
                Rule::unique('users', 'username')->ignore($this->route('user'))
            ],
            'password' => $pass[$this->input('_method')],
            'locale' => [],
            'position' => [],
            'mac_address' => []
        ];
    }

    public function messages(): array {
        return [
            'username.unique' => __('admin.user.uniq_login')
        ];
    }
}
