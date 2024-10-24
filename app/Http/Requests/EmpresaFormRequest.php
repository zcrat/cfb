<?php

namespace App\Http\Requests;

use App\Http\Requests\General\validation;
use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            'nombre' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'rfc' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:12',
                'max:13'
            ],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'direccion' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'tel_negocio' => [
                'required',
                'regex:(^(' . Validation::telefono() . ')$)',
                'min:4',
                'max:120'
            ],
            
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'email' => 'email',
            'direccion' => 'Dirección',
            'tel_negocio' => 'Tel_negocio',
        ];
    }

}
