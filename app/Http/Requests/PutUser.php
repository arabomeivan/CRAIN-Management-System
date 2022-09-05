<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PutUser extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'email' => [
                'sometimes',
                'string',
                Rule::unique('users')
                    ->ignore($user->id)
            ],
            'name' => 'sometimes|string',
            'password' => 'sometimes|string',
            'role_id' => 'sometimes|exists:roles,id'
        ];
    }
}
