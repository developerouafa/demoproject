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
            'name' => ['required', 'max:100'],
            'nickname' => ['required', 'max:100'],
            'firstname' => ['required', 'max:100'],
            'lastname' => ['required', 'max:100'],
            'designation' => ['required', 'max:100'],
            'address' => ['required', 'max:100'],
            'biographicalinfo' => ['required', 'max:100'],
            'phone' => ['required', 'max:10'],
            'website' => ['required', 'max:100'],
            'twitter' => ['required', 'max:100'],
            'facebook' => ['required', 'max:100'],
            'google' => ['required', 'max:100'],
            'linkedin' => ['required', 'max:100'],
            'github' => ['required', 'max:100']
        ];
    }
    public function messages()
    {
        return[
                'name.required' =>__('messagevalidation.users.namerequired'),
                'name.max' =>__('messagevalidation.users.namemax'),
                'nickname.required' =>__('messagevalidation.users.isrequired'),
                'nickname.max' =>__('messagevalidation.users.ismax'),
                'firstname.required' =>__('messagevalidation.users.isrequired'),
                'firstname.max' =>__('messagevalidation.users.ismax'),
                'lastname.required' =>__('messagevalidation.users.isrequired'),
                'lastname.max' =>__('messagevalidation.users.ismax'),
                'designation.required' =>__('messagevalidation.users.isrequired'),
                'designation.max' =>__('messagevalidation.users.ismax'),
                'address.required' =>__('messagevalidation.users.isrequired'),
                'address.max' =>__('messagevalidation.users.ismax'),
                'website.required' =>__('messagevalidation.users.isrequired'),
                'website.max' =>__('messagevalidation.users.ismax'),
                'twitter.required' =>__('messagevalidation.users.isrequired'),
                'twitter.max' =>__('messagevalidation.users.ismax'),
                'facebook.required' =>__('messagevalidation.users.isrequired'),
                'facebook.max' =>__('messagevalidation.users.ismax'),
                'google.required' =>__('messagevalidation.users.isrequired'),
                'google.max' =>__('messagevalidation.users.ismax'),
                'linkedin.required' =>__('messagevalidation.users.isrequired'),
                'linkedin.max' =>__('messagevalidation.users.ismax'),
                'github.required' =>__('messagevalidation.users.isrequired'),
                'github.max' =>__('messagevalidation.users.ismax'),

                'phone.required' =>__('messagevalidation.users.isrequired'),
                'phone.max' =>__('messagevalidation.users.isphonemax'),
                'biographicalinfo.max' =>__('messagevalidation.users.isbiographicalinfomax'),
        ];
    }
}
