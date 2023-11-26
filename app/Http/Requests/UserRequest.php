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
            'surname' => __('admin.user.lastname'),
            'role_id' => __('admin.user.role'),
            'username' => __('admin.user.username'),
            'password' => __('admin.user.password')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        $pass = [
            null => ['required', 'min:6'],
            'PUT' => []
        ];

        return [
            'name' => ['required'],
            'surname' => ['required'],
            'patronymic' => [],
            'role_id' => ['required'],
            'organ_id' => [],
            'username' => ['required', 'string', Rule::unique('users', 'username')
                ->ignore($this->route('user'))
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
