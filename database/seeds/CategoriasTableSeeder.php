<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $categorias = ['Servicios','Productos'];
        foreach($categorias as $categoria){
            Categoria::create([
                'nombre' => $categoria
            ]);
        }
    }
}
