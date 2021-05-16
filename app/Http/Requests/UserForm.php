<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
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
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $route = $this->route();
            if ($route->named('profile.update') || $route->named('password.update')) {
                return true;
            }

            return Gate::allows(Role::PERMISSION_EDIT_USER);
        }

        return Gate::allows(Role::PERMISSION_CREATE_USER);
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'type' => [
                Rule::requiredIf($route->named('user.*')),
                Rule::in([User::TYPE_ADMIN, User::TYPE_USER]),
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
                'min:8',
            ],
        ];

        // change rule validation for update
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id ?? null),
                ],
                'type' => [
                    Rule::requiredIf($route->named('users.*')),
                    Rule::in([User::TYPE_ADMIN, User::TYPE_USER]),
                ],
                'password' => [
                    'nullable',
                    'string',
                    'confirmed',
                    'min:8',
                ],
            ];

            // change rule validation for update profile
            if ($route->named('profile.update')) {
                // get current user
                $user = $this->user();

                $rules['email'] = [
                    'required',
                    'string',
                    'email',
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
