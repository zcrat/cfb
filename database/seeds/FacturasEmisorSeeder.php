<?php

use Illuminate\Database\Seeder;
use App\FacturasEmisor;

class FacturasEmisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacturasEmisor::create([
            'id' => 1,
            'n_certificado' => '20001000000300022815',
            'archivo_cer' => 'LAN7008173R5.cer',
            'archivo_key' => 'LAN7008173R5.key',
            'clave_key' => '12345678a',
            'rfc_emisor' => 'LAN7008173R5', // password
            'nombre_emisor' => 'ALBERTO ESQUIVIAS FLORES',
            'regimen_emisor' => '601',
            'codigo_emisor' => '58000',
            'serie_factura' => 'A',
            'folio_factura' => '1',
        ]);
    }
}
