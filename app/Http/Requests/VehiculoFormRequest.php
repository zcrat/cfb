<?php

namespace App\Http\Requests;

use App\Http\Requests\General\Validation;
use Illuminate\Foundation\Http\FormRequest;

class VehiculoFormRequest extends FormRequest
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
            'tipo' => [
                'requred',
            ],
            'marca_id' => [
                'required',
            ],
            'modelo_id' => [
                'required',
            ],
            'color_id' => [
                'required',
            ],
            'placas' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:7',
                'max:9'
            ],
            'anio' => [
                'required',
                'digits:4'
            ],
            'no_economico' => [
                'required',
                'regex:(^(' . Validation::texto() . ')$)',
                'min:1',
                'max:120'
            ],
            'vim' => [
                'required',
                'min:17',
                'max:30',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'tipo_id' => 'Tipo vehículo',
            'marca_id' => 'Marca',
            'modelo_id' => 'Modelo',
            'color_id' => 'Color',
            'placas' => 'Placas',
            'anio' => 'Año',
            'no_economico' => 'Número ecónomico',
            'vim' => 'VIM',
        ];
    }
}
