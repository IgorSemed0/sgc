<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar um usuário Admin
        User::create([
            'primeiro_nome' => 'Admin',
            'nomes_meio' => '',
            'ultimo_nome' => 'User',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('12345678'), // Use uma senha segura em produção
            'bi' => '123456789',
            'telefone' => '1234567890',
            'tipo_usuario' => 'admin', // Tipo de usuário: Admin
        ]);

        // Criar um usuário Morador
        User::create([
            'primeiro_nome' => 'João',
            'nomes_meio' => 'Silva',
            'ultimo_nome' => 'Morador',
            'email' => 'morador@gmail.com',
            'username' => 'joaosilva',
            'password' => Hash::make('12345678'), // Use uma senha segura em produção
            'bi' => '987654321',
            'telefone' => '0987654321',
            'tipo_usuario' => 'morador', // Tipo de usuário: Morador
        ]);

        // Criar um usuário Funcionário
        User::create([
            'primeiro_nome' => 'Maria',
            'nomes_meio' => 'Fernandes',
            'ultimo_nome' => 'Funcionário',
            'email' => 'funcionario@gmail.com',
            'username' => 'mariafernandes',
            'password' => Hash::make('12345678'), // Use uma senha segura em produção
            'bi' => '112233445',
            'telefone' => '1122334455',
            'tipo_usuario' => 'funcionario', // Tipo de usuário: Funcionário
        ]);
    }
}