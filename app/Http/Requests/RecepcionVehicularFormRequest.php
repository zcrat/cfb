<?php

namespace App\Http\Requests;

use App\Http\Requests\General\Validation;
use Illuminate\Foundation\Http\FormRequest;

class RecepcionVehicularFormRequest extends FormRequest
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
        return $this;
        return [

        ];
    }

    public function attributes()
    {
        return [
            'cliente_id' => 'Cliente',
            'vehiculo_id' => 'Vehículo',
            'notas_adicionales' => 'Notas adicionales',
            'indicaciones_del_cliente' => 'Indicaciones del cliente',
            'orden_seguimiento' => 'Orden de seguimiento',
            'km_entrada' => 'Km entrada',
            'km_salida' => 'Km Salida',
            'gas_entrada' => 'Gasolina entrada',
            'gas_salida' => 'Gasolina salida',
            'fecha' => 'Fecha',
        ];
    }

}
