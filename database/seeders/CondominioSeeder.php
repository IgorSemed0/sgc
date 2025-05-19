<?php

namespace Database\Seeders;

use App\Models\Bloco;
use App\Models\Edificio;
use App\Models\Unidade;
use App\Models\User;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Departamento;
use App\Models\Visitante;
use App\Models\Acesso;
use App\Models\Conta;
use App\Models\Movimento;
use App\Models\Despesa;
use App\Models\Rupe;
use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\Pagamento;
use App\Models\EspacoComum;
use App\Models\EspacoReserva;
use App\Models\ChatPost;
use App\Models\ChatComentario;
use App\Models\Notificacao;
use App\Models\Votacao;
use App\Models\OpcaoVotacao;
use App\Models\Voto;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class CondominioSeeder extends Seeder
{
    /**
     * Executa a sementeira para o sistema de gestão.
     * Ajustado para gerar aproximadamente 50% dos registros originais nas entidades volumosas.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_PT');

        // 1. Criar Blocos (mantém 3)
        $blocos = [];
        for ($i = 1; $i <= 3; $i++) {
            $blocos[] = Bloco::create([
                'nome' => "Bloco {$i}",
                'descricao' => "Bloco {$i} residencial",
            ]);
        }

        // 2. Criar Edifícios (1 por bloco para 50%)
        $edificios = [];
        foreach ($blocos as $bloco) {
            $edificios[] = Edificio::create([
                'nome' => "Edifício 1",
                'descricao' => "Edifício 1 do {$bloco->nome}",
                'bloco_id' => $bloco->id,
            ]);
        }

        // 3. Criar Unidades (2 por edifício = ~50%)
        $unidades = [];
        $tiposUnidade = ['Apartamento', 'Sala Comercial', 'Casa'];
        $statusUnidade = ['alugada', 'disponivel'];
        foreach ($edificios as $edificio) {
            for ($i = 1; $i <= 2; $i++) {
                $unidades[] = Unidade::create([
                    'tipo' => $faker->randomElement($tiposUnidade),
                    'numero' => "U{$i}",
                    'bloco_id' => $edificio->bloco_id,
                    'edificio_id' => $edificio->id,
                    'andar' => $faker->numberBetween(1, 10),
                    'status' => $faker->randomElement($statusUnidade),
                ]);
            }
        }

        // 4. Criar Usuários (5 = 50%)
        $users = [];
        $tiposUsuario = ['admin', 'morador', 'funcionario'];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'primeiro_nome' => $faker->firstName,
                'nomes_meio' => $faker->optional()->firstName,
                'ultimo_nome' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password123'),
                'bi' => $faker->numerify('##########LA#'),
                'telefone' => '+244' . $faker->numerify('9########'),
                'tipo_usuario' => $faker->randomElement($tiposUsuario),
            ]);
        }

        // 5. Criar Departamentos (mantém 3)
        $departamentos = [];
        $nomesDepartamentos = ['Administração', 'Segurança', 'Limpeza'];
        foreach ($nomesDepartamentos as $nome) {
            $departamentos[] = Departamento::create([
                'nome' => $nome,
                'descricao' => "Departamento de {$nome}",
            ]);
        }

        // 6. Criar Moradores (~35% das unidades)
        $moradores = [];
        $tiposMorador = ['proprietario', 'inquilino', 'dependente'];
        $inquilinosPorUnidade = [];
        foreach ($unidades as $unidade) {
            if ($faker->boolean(35)) {
                $tipo = $faker->randomElement($tiposMorador);
                $dependenteDe = null;
                if ($tipo == 'dependente') {
                    if (isset($inquilinosPorUnidade[$unidade->id]) && !empty($inquilinosPorUnidade[$unidade->id])) {
                        $dependenteDe = $faker->randomElement($inquilinosPorUnidade[$unidade->id]);
                    } else {
                        // Criar um inquilino primeiro
                        $inquilino = Morador::create([
                            'primeiro_nome' => $faker->firstName,
                            'nomes_meio' => $faker->optional()->firstName,
                            'ultimo_nome' => $faker->lastName,
                            'email' => $faker->safeEmail,
                            'telefone' => '+244' . $faker->numerify('9########'),
                            'bi' => $faker->numerify('##########LA#'),
                            'cedula' => $faker->unique()->numerify('C#####'),
                            'data_nascimento' => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
                            'sexo' => $faker->randomElement(['Masculino', 'Feminino']),
                            'unidade_id' => $unidade->id,
                            'tipo' => 'inquilino',
                            'estado_residente' => $faker->randomElement([1, 0]),
                            'dependente_de' => null,
                        ]);
                        $dependenteDe = $inquilino->id;
                        if (!isset($inquilinosPorUnidade[$unidade->id])) {
                            $inquilinosPorUnidade[$unidade->id] = [];
                        }
                        $inquilinosPorUnidade[$unidade->id][] = $inquilino->id;
                        $moradores[] = $inquilino; // Adicionar o inquilino à lista de moradores
                    }
                }
                $morador = Morador::create([
                    'primeiro_nome' => $faker->firstName,
                    'nomes_meio' => $faker->optional()->firstName,
                    'ultimo_nome' => $faker->lastName,
                    'email' => $faker->safeEmail,
                    'telefone' => '+244' . $faker->numerify('9########'),
                    'bi' => $faker->numerify('##########LA#'),
                    'cedula' => $faker->unique()->numerify('C#####'),
                    'data_nascimento' => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
                    'sexo' => $faker->randomElement(['Masculino', 'Feminino']),
                    'unidade_id' => $unidade->id,
                    'tipo' => $tipo,
                    'estado_residente' => $tipo == 'proprietario' ? $faker->randomElement([1, 0]) : 1,
                    'dependente_de' => $dependenteDe,
                ]);
                if ($tipo == 'inquilino') {
                    if (!isset($inquilinosPorUnidade[$unidade->id])) {
                        $inquilinosPorUnidade[$unidade->id] = [];
                    }
                    $inquilinosPorUnidade[$unidade->id][] = $morador->id;
                }
                $moradores[] = $morador;
            }
        }

        // 7. Criar Funcionários (mantém 1 por departamento)
        $funcionarios = [];
        foreach ($departamentos as $departamento) {
            $tipo = $faker->randomElement(['Particular', 'Geral']);
            $unidade_id = ($tipo == 'Particular') ? $faker->randomElement($unidades)->id : 1;
            $cargo = ($tipo == 'Particular') ? $faker->jobTitle : 'Geral';
            $funcionarios[] = Funcionario::create([
                'primeiro_nome' => $faker->firstName,
                'nomes_meio' => $faker->optional()->firstName,
                'ultimo_nome' => $faker->lastName,
                'email' => $faker->safeEmail,
                'telefone' => '+244' . $faker->numerify('9########'),
                'bi' => $faker->numerify('##########LA#'),
                'dt_nascimento' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'sexo' => $faker->randomElement(['Masculino', 'Feminino']),
                'cargo' => $cargo,
                'unidade_id' => $unidade_id,
                'departamento_id' => $departamento->id,
                'tipo' => $tipo,
            ]);
        }

        // 8. Criar Visitantes (~35% das unidades)
        $visitantes = [];
        foreach ($unidades as $unidade) {
            if ($faker->boolean(35)) {
                $visitantes[] = Visitante::create([
                    'primeiro_nome' => $faker->firstName,
                    'nomes_meio' => $faker->optional()->firstName,
                    'ultimo_nome' => $faker->lastName,
                    'bi' => $faker->numerify('##########LA#'),
                    'email' => $faker->safeEmail,
                    'telefone' => '+244' . $faker->numerify('9########'),
                    'motivo_visita' => $faker->sentence,
                    'unidade_id' => $unidade->id,
                ]);
            }
        }

        // 9. Criar Acessos (~45% chance)
        foreach (['Morador' => $moradores, 'Funcionario' => $funcionarios, 'Visitante' => $visitantes] as $tipo => $entidades) {
            foreach ($entidades as $entidade) {
                if ($faker->boolean(45)) {
                    for ($i = 1; $i <= 1; $i++) { // 1 acesso
                        Acesso::create([
                            'entidade_id' => $entidade->id,
                            'tipo_pessoa' => $tipo,
                            'data_hora' => $faker->dateTimeBetween('-1 year', 'now'),
                            'tipo' => $faker->randomElement(['Entrada', 'Saída']),
                            'observacao' => $faker->sentence,
                        ]);
                    }
                }
            }
        }

        // 10. Criar Contas (mantém 2)
        $contas = [];
        for ($i = 1; $i <= 2; $i++) {
            $contas[] = Conta::create([
                'nome' => "Conta {$i}",
                'tipo' => 'Corrente',
                'saldo' => $faker->numberBetween(10000, 100000),
            ]);
        }

        // 11. Criar Movimentos (2 por conta)
        foreach ($contas as $conta) {
            for ($i = 1; $i <= 2; $i++) {
                Movimento::create([
                    'conta_id' => $conta->id,
                    'tipo' => $faker->randomElement(['Crédito', 'Débito']),
                    'valor' => $faker->numberBetween(100, 5000),
                    'descricao' => $faker->sentence,
                    'data_movimento' => $faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
        }

        // 12. Criar Despesas (8)
        for ($i = 1; $i <= 8; $i++) {
            Despesa::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(500, 10000),
                'data_despesa' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 13. Criar Rupes (5)
        for ($i = 1; $i <= 5; $i++) {
            Rupe::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(1000, 20000),
                'data_receita' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 14. Criar Facturas (~45% unidades, 1 por unidade)
        $facturas = [];
        foreach ($unidades as $unidade) {
            if ($faker->boolean(45)) {
                $facturas[] = Factura::create([
                    'unidade_id' => $unidade->id,
                    'referencia' => $faker->numerify('F#####'),
                    'data_emissao' => $faker->dateTimeBetween('-1 year', 'now'),
                    'data_vencimento' => $faker->dateTimeBetween('now', '+1 month'),
                    'valor_total' => $faker->numberBetween(1000, 5000),
                    'status' => $faker->randomElement(['Pendente', 'Pago', 'Cancelado']),
                ]);
            }
        }

        // 15. Criar Factura Items (1 por factura)
        foreach ($facturas as $factura) {
            FacturaItem::create([
                'factura_id' => $factura->id,
                'categoria' => $faker->randomElement(['Água', 'Energia', 'Manutenção']),
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(200, 2000),
            ]);
        }

        // 16. Criar Pagamentos (~45% de facturas pagas)
        foreach ($facturas as $factura) {
            if ($factura->status === 'Pago' && $faker->boolean(45)) {
                Pagamento::create([
                    'factura_id' => $factura->id,
                    'data_pagamento' => $faker->dateTimeBetween($factura->data_emissao, 'now'),
                    'valor_pago' => $factura->valor_total,
                    'metodo_pagamento' => $faker->randomElement(['Multicaixa', 'Transferência', 'Dinheiro']),
                ]);
            }
        }

        // 17. Criar Espaços Comuns (~35% dos blocos)
        $espacosComuns = [];
        foreach ($blocos as $bloco) {
            if ($faker->boolean(35)) {
                $espacosComuns[] = EspacoComum::create([
                    'nome' => $faker->randomElement(['Piscina', 'Salão de Festas', 'Ginásio']),
                    'descricao' => $faker->sentence,
                    'bloco_id' => $bloco->id,
                    'regras' => $faker->paragraph,
                ]);
            }
        }

        // 18. Criar Reservas de Espaços (1 por espaço)
        foreach ($espacosComuns as $espaco) {
            EspacoReserva::create([
                'espaco_id' => $espaco->id,
                'user_id' => $faker->randomElement($users)->id,
                'data_reserva' => $faker->dateTimeBetween('now', '+1 month'),
                'hora_inicio' => $faker->time('H:i'),
                'hora_fim' => $faker->time('H:i'),
                'status' => $faker->randomElement(['Confirmada', 'Pendente', 'Cancelada']),
            ]);
        }

        // 19. Criar Chat Posts (~35% dos usuários)
        $chatPosts = [];
        foreach ($users as $user) {
            if ($faker->boolean(35)) {
                $chatPosts[] = ChatPost::create([
                    'autor_id' => $user->id,
                    'tipo_autor' => $user->tipo_usuario,
                    'titulo' => $faker->sentence,
                    'conteudo' => $faker->paragraph,
                    'data_publicacao' => $faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
        }

        // 20. Criar Chat Comentários (1 por post)
        foreach ($chatPosts as $post) {
            ChatComentario::create([
                'post_id' => $post->id,
                'user_id' => $faker->randomElement($users)->id,
                'conteudo' => $faker->sentence,
                'data_comentario' => $faker->dateTimeBetween($post->data_publicacao, 'now'),
            ]);
        }

        // 21. Criar Notificações (1 por usuário)
        foreach ($users as $user) {
            Notificacao::create([
                'user_id' => $user->id,
                'tipo' => $faker->randomElement(['Aviso', 'Factura', 'Evento']),
                'titulo' => $faker->sentence,
                'conteudo' => $faker->paragraph,
                'data_hora' => $faker->dateTimeBetween('-1 year', 'now'),
                'lida' => $faker->boolean,
            ]);
        }

        // 22. Criar Votações (1 votação)
        $votacoes = [];
        $votacoes[] = Votacao::create([
            'titulo' => $faker->sentence,
            'descricao' => $faker->paragraph,
            'data_inicio' => $faker->dateTimeBetween('-1 month', 'now'),
            'data_fim' => $faker->dateTimeBetween('now', '+1 month'),
            'quorum_minimo' => $faker->numberBetween(10, 50),
            'status' => $faker->randomElement(['Aberta', 'Fechada']),
        ]);

        // 23. Criar Opções de Votação (1 por votação)
        $opcoes = [];
        foreach ($votacoes as $votacao) {
            $opcoes[] = OpcaoVotacao::create([
                'votacao_id' => $votacao->id,
                'descricao' => $faker->sentence,
            ]);
        }

        // 24. Criar Votos (~12% chance)
        foreach ($votacoes as $votacao) {
            foreach ($users as $user) {
                if ($faker->boolean(12)) {
                    Voto::create([
                        'votacao_id' => $votacao->id,
                        'user_id' => $user->id,
                        'opcao_id' => $opcoes[0]->id,
                        'data_hora' => $faker->dateTimeBetween($votacao->data_inicio, $votacao->data_fim),
                        'hash_voto' => $faker->sha256,
                    ]);
                }
            }
        }
    }
}