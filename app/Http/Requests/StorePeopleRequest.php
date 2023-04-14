<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeopleRequest extends FormRequest
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
        return [
            'name' => 'required|min:3|max:60',
            'document' => 'required|min:11|max:14',
        ];
    }

    public function messages()
    {
        $name = [
            'name' => 'Nome da Pessoa',
            'document' => 'Documento',
        ];

        return [
            "name.required" => "Campo de " . $name['name'] . " é obrigatório.",
            "name.min" => "Campo " . $name['name'] . " deve ter no mínimo :min caracteres.",
            "name.max" => "Campo " . $name['name'] . " deve ter no máximo :max caracteres.",
            "document.required" => "Campo de " . $name['document'] . " é obrigatório.",
            "document.min" => "Campo " . $name['document'] . " deve ter no mínimo :min caracteres.",
            "document.max" => "Campo " . $name['document'] . " deve ter no máximo :max caracteres.",
        ];
    }
}
