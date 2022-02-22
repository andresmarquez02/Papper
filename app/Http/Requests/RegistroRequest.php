<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
            'usuario' => 'required|string|min:5|max:100|unique:users,nombre_apellido',
            'correo' => 'required|email|min:5|max:100|unique:users,email',
            'contrasena' => 'required|min:5|max:254'
        ];
    }
    public function messages()
    {
        return [
            "usuario.required" => "El usuario es requerido",
            "usuario.min" => "El usuario debe tener minimo 5 caracteres",
            "usuario.max" => "Usuario muy extenso",
            "usuario.unique" => "Este nombre de usuario ya existe",
            "correo.require" => "El correo es requerido",
            "correo.email" => "El correo no es valido",
            "correo.min" => "El correo debe tener minimo 5 caracteres",
            "correo.max" => "Correo electronico muy extenso",
            "correo.unique" => "Este correo ya existe",
            "contrasena.required" => "La contraseña es requerida",
            "contrasena.min" => "La contraseña debe tener minimo 5 caracteres",
            "contrasena.max" => "Contraseña muy extensa, es propenso que despues no la recuerde",
        ];
    }
}
