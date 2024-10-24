<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PersonasTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(EmpresasTableSeeder::class);
         //$this->call(CustomerTableSeeder::class);
         $this->call(MarcasTableSeeder::class);
         $this->call(ColoresTableSeeder::class);
         $this->call(CategoriasTableSeeder::class);
         $this->call(FacturasEmisorSeeder::class);
         $this->call(TipoAutoTableSeeder::class);
//         $this->call(SegurosTableSeeder::class);
         $this->call(EstadoEquipoSeeder::class);
         $this->call(CodigoSatSeeder::class);
         $this->call(UnidadSatSeeder::class);
         $this->call(ArticuloSeeder::class);
         $this->call(CotizacionesSeeder::class);
         $this->call(DetalleCotizacionSeeder::class);
    }
}
