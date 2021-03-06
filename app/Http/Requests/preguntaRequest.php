<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class preguntaRequest extends FormRequest
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
            'titulo' => 'required|string|max:254|min:1',
            'descripcion' => 'required|string',
            'grupo' => 'required|numeric|exists:grupos,id',
        ];
    }
    public function message(){
        return [
            'titulo.required' => 'El titulo es requerido',
            'titulo.max' => 'El titulo es muy extenso',
            'descripcion.required' => 'La descripcion es requerida',
            'grupo.required' => 'El grupo requerido',
            'grupo.exists' => 'El gurpo selecionado no existe',
        ];
    }
}
