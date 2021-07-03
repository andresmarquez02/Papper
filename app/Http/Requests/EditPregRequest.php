<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPregRequest extends FormRequest
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
            'titulo' => 'required|string|min:2',
            'descripcion' => 'required|string|min:2',
            'id_grupo' => 'required|numeric|exists:grupos,id',
        ];
    }
}
