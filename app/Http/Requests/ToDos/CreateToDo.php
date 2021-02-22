<?php

namespace App\Http\Requests\ToDos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateToDo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('add_to_dos') ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to_do'      => 'required|max:255',
            'completed'  => 'required|boolean',
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
            'to_do.required'     => 'Informe a tarefa a ser criada.',
            'to_do.max'          => 'O texto da tarefa não pode ter mais que 255 caracteres.',
            'completed.required' => 'Informe se a tarefa está completa ou não.',
            'completed.boolean'  => 'Formato de dados iinválido no campo completa.',
        ];
    }
}
