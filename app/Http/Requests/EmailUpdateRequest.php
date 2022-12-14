<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->user()->id)]
        ];
    }
    public function messages()
    {
        return[
                'email.required' =>__('messagevalidation.users.emailrequired'),
                'email.email' =>__('messagevalidation.users.emailemail'),
                'email.unique' =>__('messagevalidation.users.emailunique'),
        ];
    }
}
