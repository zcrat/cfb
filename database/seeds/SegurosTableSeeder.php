<?php

use Illuminate\Database\Seeder;
use App\Seguro;

class SegurosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Seguro::class,20)->create();
    }
}
