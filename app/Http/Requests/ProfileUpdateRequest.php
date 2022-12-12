<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'name' => ['string', 'max:255'],
            'nickname' => ['string', 'max:255'],
            'firstname' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'designation' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'biographicalinfo' => ['string', 'max:255'],
            // 'phone' => ['string', 'digits:10'],
            'website' => ['string', 'max:255'],
            'twitter' => ['string', 'max:255'],
            'facebook' => ['string', 'max:255'],
            'google' => ['string', 'max:255'],
            'linkedin' => ['string', 'max:255'],
            'github' => ['string', 'max:255']
        ];
    }
}
