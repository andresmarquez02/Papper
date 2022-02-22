<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'correo' => 'required|email|min:5|max:100',
            'contrasena' => 'required|min:5|max:254'
        ];
    }
    public function messages()
    {
        return [
            "correo.require" => "El correo es requerido",
            "correo.email" => "El correo no es valido",
            "correo.min" => "El correo debe tener minimo 5 caracteres",
            "correo.max" => "Correo electronico muy extenso",
            "contrasena.required" => "La contraseña es requerida",
            "contrasena.min" => "La contraseña debe tener minimo 5 caracteres",
            "contrasena.max" => "Contraseña muy extensa, es propenso que despues no la recuerde",
        ];
    }
}
