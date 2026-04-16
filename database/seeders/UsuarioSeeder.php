<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Usuario::updateOrCreate(
            ['ds_usuario' => 'adm@patrimon.io'],
            [
                'ds_nome' => 'Administrador',
                'ds_senha' => Hash::make('123456'), // HASH! Nunca senhas em texto simples
                'ie_acesso' => 'A',
                'ie_status' => 'A',
            ]
        );
    }
}
