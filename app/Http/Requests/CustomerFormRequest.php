<?php

namespace App\Http\Requests;

use App\Http\Requests\General\Validation;
use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
            'empresa_id' => [
                'nullable',
                'numeric'
            ],
            'usuario' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'direccion' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'ciudad' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'estado' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:4',
                'max:120'
            ],
            'cp' => [
                'required',
                'digits:5',
            ],
            'tel_casa' => [
                'required',
                'regex:(^(' . Validation::telefono() . ')$)',
                'min:7',
                'max:15'
            ],
            'tel_oficina' => [
                'required',
                'regex:(^(' . Validation::telefono() . ')$)',
                'min:7',
                'max:15'
            ],
            'tel_celular' => [
                'nullable',
                'regex:(^(' . Validation::telefono() . ')$)',
                'min:10',
                'max:15'
            ],
            'email' => [
                'nullable'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'empresa_id' => 'Seleccione una empresa',
            'usuario' => 'Nombre',
            'direccion' => 'Dirección',
            'ciudad' => 'Ciudad',
            'estado' => 'Estado',
            'cp' => 'Cp',
            'tel_casa' => 'Teléfono casa',
            'tel_oficina' => 'Teléfono oficina',
            'tel_celular' => 'Teléfono celular',
            'email' => 'Correo',
        ];
    }
}
