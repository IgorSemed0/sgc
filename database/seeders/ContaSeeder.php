<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conta;
use Illuminate\Database\Seeder;

class ContaSeeder extends Seeder
{
    public function run()
    {
        Conta::create([
            'nome' => 'Conta Principal',
            'tipo' => 'principal',
            'saldo' => 0,
        ]);
    }
}
