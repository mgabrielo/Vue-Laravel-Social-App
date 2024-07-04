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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string','min:3', 'max:255', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[\w\-\.]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {
        return[
            'username.regex' => 'Username can only contain alphanumeric characters,including A-Z,a-z,0-9,dash(-) and dot(.)',
            'min'=> 'Username must be at least 3 characters'
        ];
    }
}
