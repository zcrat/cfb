<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        factory(User::class,20)->create();
        $datos = [[
            'id' => 1,
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'usuario' => 'Admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 2,
            'name' => 'oscarakumas',
            'email' => 'oscar_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'oscarakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 3,
            'name' => 'mauricioakumas',
            'email' => 'mauricio_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'mauricioakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 7,
            'name' => 'irisakumas',
            'email' => 'iris_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'irisakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 8,
            'name' => 'froylanakumas',
            'email' => 'froylan_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'froylanakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 9,
            'name' => 'araceliakumas',
            'email' => 'araceli_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'araceliakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ],
        [
            'id' => 10,
            'name' => 'analleliakumas',
            'email' => 'analleli_akumas@akumas.mx',
            'email_verified_at' => now(),
            'usuario' => 'analleliakumas',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'condicion' => true,
            'idrol' => 1,
            'remember_token' => Str::random(10),
        ]];

        foreach($datos as $dato){
            User::create($dato);
        }
    }
}
