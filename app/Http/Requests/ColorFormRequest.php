<?php

namespace App\Http\Requests;

use App\Http\Requests\General\Validation;
use Illuminate\Foundation\Http\FormRequest;

class ColorFormRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
        ];
    }
}
