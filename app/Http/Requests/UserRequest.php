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
            'name' => "Ism",
            'email' => "Elektron pochta",
            'password' => "Parol"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'email' => ['required'],
            'password' => ['required'],
            'name' => [],
            'lastname' => [],
            'patronymic' => [],
            'position' => [],
            'locale' => [],
            'mac_address' => []
        ];
    }
}
