<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('add_users') ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:8|confirmed',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'O nome é obrigatório.',
            'name.max'              => 'O nome não pode ter mais que 255 caracteres.',
            'email.required'        => 'O email é obrigatório.',
            'email.unique'          => 'Email já cadastrado para outro usuário.',
            'email.max'             => 'O email não pode ter mais que 255 caracteres.',
            'password.required'     => 'A senha é obrigatória.',
            'password.min'          => 'A senha não pode ter menos que 8 caracteres.',
            'password.confirmed'    => 'A confirmação de senha não bate com a senha informada.',
        ];
    }
}
