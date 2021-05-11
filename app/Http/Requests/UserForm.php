<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = $this->route();
        $user = $this->route('user');

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'username' => [
                'required',
                'string',
                'alpha',
                'max:255',
                'unique:users,email',
            ],
            'type' => [
                'required',
                Rule::in([User::TYPE_ADMIN, User::TYPE_USER]),
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
            ],
        ];

        // change rule validation for update
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['username'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id ?? null),
            ];
            $rules['password'] = [
                'nullable',
                'string',
                'confirmed',
                'min:8',
            ];

            // change rule validation for update profile
            if ($route->named('profile.update')) {
                // get current user
                $user = $this->user();

                $rules['username'] = [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ];
            }

            // change rule validation for update password
            if ($route->named('password.update')) {
                $rules = [];
                $rules['current_password'] = [
                    'required',
                    'string',
                    'password',
                    'min:8',
                ];
                $rules['password'] = [
                    'required',
                    'string',
                    'confirmed',
                    'min:8',
                ];
            }
        }

        return $rules;
    }
}
