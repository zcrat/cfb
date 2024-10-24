<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 03/05/2019
 * Time: 12:06 PM
 */

namespace App\Http\Requests\General;


class Validation
{
    public static function texto(){
        return '[\d\w\á\Á\é\É\í\Í\ó\Ó\ú\Ú\ü\Ü\ñ\Ñ\.\#\-\,\s]+';
    }
    public static function telefono(){
        return '[0-9]{7,15}';
    }
}