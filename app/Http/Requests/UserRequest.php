<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => __('admin.user.email'),
            'password' => __('admin.user.password'),
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
            'role' => [],
            'organ' => [],
            'email' => ['required'],
            'password' => ['required'],
            'locale' => [],
            'position' => [],
            'mac_address' => []
        ];
    }
}
