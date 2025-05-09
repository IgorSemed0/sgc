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
use Carbon\Carbon;

class CondominioSeeder extends Seeder
{
    /**
     * Executa a sementeira para o sistema de gestão.
     * Reduzido para 70% dos registros originais.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_PT');

        // 1. Criar Blocos (Reduzido de 6 para 4)
        $blocos = [];
        for ($i = 1; $i <= 4; $i++) {
            $blocos[] = Bloco::create([
                'nome' => "Bloco {$i}",
                'descricao' => "Bloco {$i} residencial",
            ]);
        }

        // 2. Criar Edifícios (2 por bloco mantido)
        $edificios = [];
        foreach ($blocos as $bloco) {
            for ($i = 1; $i <= 2; $i++) {
                $edificios[] = Edificio::create([
                    'nome' => "Edifício {$i}",
                    'descricao' => "Edifício {$i} do {$bloco->nome}",
                    'bloco_id' => $bloco->id,
                ]);
            }
        }

        // 3. Criar Unidades (Reduzido de 10 para 7 por edifício)
        $unidades = [];
        $tiposUnidade = ['Casa', 'Apartamento', 'Estacionamento'];
        foreach ($edificios as $edificio) {
            $bloco = Bloco::find($edificio->bloco_id);
            for ($i = 1; $i <= 7; $i++) {
                $unidades[] = Unidade::create([
                    'tipo' => $faker->randomElement($tiposUnidade),
                    'numero' => "U{$i}",
                    'bloco_id' => $bloco->id,
                    'edificio_id' => $edificio->id,
                    'andar' => $faker->numberBetween(1, 10),
                    'area_m2' => $faker->numberBetween(50, 200),
                    'status' => $faker->randomElement(['Ocupada', 'Vazia']),
                ]);
            }
        }

        // 4. Criar Usuários (Reduzido de 20 para 14)
        $users = [];
        $tiposUsuario = ['Administrador', 'Morador', 'Funcionário'];
        for ($i = 1; $i <= 14; $i++) {
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

        // 5. Criar Departamentos (Mantido os 4 departamentos essenciais)
        $departamentos = [];
        $nomesDepartamentos = ['Administração', 'Segurança', 'Limpeza', 'Manutenção'];
        foreach ($nomesDepartamentos as $nome) {
            $departamentos[] = Departamento::create([
                'nome' => $nome,
                'descricao' => "Departamento de {$nome}",
            ]);
        }

        // 6. Criar Moradores (Reduzido de até 3 para até 2 por unidade)
        $moradores = [];
        $tiposMorador = ['Proprietário', 'Inquilino', 'Dependente'];
        foreach ($unidades as $unidade) {
            for ($i = 1; $i <= $faker->numberBetween(1, 2); $i++) {
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
                    'tipo' => $faker->randomElement($tiposMorador),
                    'estado_residente' => $faker->randomElement([1, 0]),
                    'dependente_de' => $faker->optional()->randomElement(Morador::pluck('id')->toArray()),
                ]);
                $moradores[] = $morador;
            }
        }

        // 7. Criar Funcionários (Reduzido de 3 para 2 por departamento)
        $funcionarios = [];
        $tiposFuncionario = ['Administrador', 'Segurança', 'Limpeza'];
        foreach ($departamentos as $departamento) {
            for ($i = 1; $i <= 2; $i++) {
                $funcionarios[] = Funcionario::create([
                    'primeiro_nome' => $faker->firstName,
                    'nomes_meio' => $faker->optional()->firstName,
                    'ultimo_nome' => $faker->lastName,
                    'email' => $faker->safeEmail,
                    'telefone' => '+244' . $faker->numerify('9########'),
                    'bi' => $faker->numerify('##########LA#'),
                    'dt_nascimento' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                    'sexo' => $faker->randomElement(['Masculino', 'Feminino']),
                    'cargo' => $faker->jobTitle,
                    'unidade_id' => $faker->randomElement($unidades)->id,
                    'departamento_id' => $departamento->id,
                    'tipo' => $faker->randomElement($tiposFuncionario),
                ]);
            }
        }

        // 8. Criar Visitantes (Reduzido de 2 para 1 por unidade)
        $visitantes = [];
        foreach ($unidades as $unidade) {
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

        // 9. Criar Acessos (Reduzido até 5 para até 3 por entidade)
        $tiposPessoa = ['morador', 'funcionario', 'visitante'];
        foreach ($tiposPessoa as $tipo) {
            $entidades = match ($tipo) {
                'Morador' => $moradores,
                'Funcionario' => $funcionarios,
                'Visitante' => $visitantes,
                'Obeservacao' => $visitantes,
            };
            foreach ($entidades as $entidade) {
                for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
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

        // 10. Criar Contas (Reduzido de 5 para 3)
        $contas = [];
        for ($i = 1; $i <= 3; $i++) {
            $contas[] = Conta::create([
                'nome' => "Conta {$i}",
                'tipo' => 'Corrente',
                'saldo' => $faker->numberBetween(10000, 100000),
            ]);
        }

        // 11. Criar Movimentos (Reduzido de 10 para 7 por conta)
        foreach ($contas as $conta) {
            for ($i = 1; $i <= 7; $i++) {
                Movimento::create([
                    'conta_id' => $conta->id,
                    'tipo' => $faker->randomElement(['Crédito', 'Débito']),
                    'valor' => $faker->numberBetween(100, 5000),
                    'descricao' => $faker->sentence,
                    'data_movimento' => $faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
        }

        // 12. Criar Despesas (Reduzido de 30 para 21)
        for ($i = 1; $i <= 21; $i++) {
            Despesa::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(500, 10000),
                'data_despesa' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 13. Criar Rupes (Receitas) (Reduzido de 20 para 14)
        for ($i = 1; $i <= 14; $i++) {
            Rupe::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(1000, 20000),
                'data_receita' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 14. Criar Facturas (Reduzido de 3 para 2 por unidade)
        $facturas = [];
        foreach ($unidades as $unidade) {
            for ($i = 1; $i <= 2; $i++) {
                $facturas[] = Factura::create([
                    'unidade_id' => $unidade->id,
                    'referencia' => $faker->numerify('F#####'),
                    'data_emissao' => $faker->dateTimeBetween('-1 year', 'now'),
                    'data_vencimento' => $faker->dateTimeBetween('now', '+1 month'),
                    'valor_total' => $faker->numberBetween(1000, 5000),
                    'status' => $faker->randomElement(['Pendente', 'Pago']),
                    'observacao' => $faker->optional()->sentence,
                ]);
            }
        }

        // 15. Criar Factura Items (Mantido 2 por factura)
        foreach ($facturas as $factura) {
            for ($i = 1; $i <= 2; $i++) {
                FacturaItem::create([
                    'factura_id' => $factura->id,
                    'categoria' => $faker->randomElement(['Água', 'Energia', 'Manutenção']),
                    'descricao' => $faker->sentence,
                    'valor' => $faker->numberBetween(200, 2000),
                ]);
            }
        }

        // 16. Criar Pagamentos (Mantido para facturas pagas)
        foreach ($facturas as $factura) {
            if ($factura->status === 'Pago') {
                Pagamento::create([
                    'factura_id' => $factura->id,
                    'data_pagamento' => $faker->dateTimeBetween($factura->data_emissao, 'now'),
                    'valor_pago' => $factura->valor_total,
                    'metodo_pagamento' => $faker->randomElement(['Multicaixa', 'Transferência', 'Dinheiro']),
                ]);
            }
        }

        // 17. Criar Espaços Comuns (Mantido 1 por bloco)
        $espacosComuns = [];
        foreach ($blocos as $bloco) {
            $espacosComuns[] = EspacoComum::create([
                'nome' => $faker->randomElement(['Piscina', 'Salão de Festas', 'Ginásio']),
                'descricao' => $faker->sentence,
                'bloco_id' => $bloco->id,
                'regras' => $faker->paragraph,
            ]);
        }

        // 18. Criar Reservas de Espaços (Reduzido de 5 para 3 por espaço)
        foreach ($espacosComuns as $espaco) {
            for ($i = 1; $i <= 3; $i++) {
                EspacoReserva::create([
                    'espaco_id' => $espaco->id,
                    'user_id' => $faker->randomElement($users)->id,
                    'data_reserva' => $faker->dateTimeBetween('now', '+1 month'),
                    'hora_inicio' => $faker->time('H:i'),
                    'hora_fim' => $faker->time('H:i'),
                    'status' => $faker->randomElement(['Confirmada', 'Pendente', 'Cancelada']),
                    'observacao' => $faker->optional()->sentence,
                ]);
            }
        }

        // 19. Criar Chat Posts (Reduzido de 2 para 1 por usuário)
        $chatPosts = [];
        foreach ($users as $user) {
            $chatPosts[] = ChatPost::create([
                'autor_id' => $user->id,
                'tipo_autor' => $user->tipo_usuario,
                'titulo' => $faker->sentence,
                'conteudo' => $faker->paragraph,
                'data_publicacao' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 20. Criar Chat Comentários (Reduzido de 3 para 2 por post)
        foreach ($chatPosts as $post) {
            for ($i = 1; $i <= 2; $i++) {
                ChatComentario::create([
                    'post_id' => $post->id,
                    'user_id' => $faker->randomElement($users)->id,
                    'conteudo' => $faker->sentence,
                    'data_comentario' => $faker->dateTimeBetween($post->data_publicacao, 'now'),
                ]);
            }
        }

        // 21. Criar Notificações (Reduzido de 5 para 3 por usuário)
        foreach ($users as $user) {
            for ($i = 1; $i <= 3; $i++) {
                Notificacao::create([
                    'user_id' => $user->id,
                    'tipo' => $faker->randomElement(['Aviso', 'Factura', 'Evento']),
                    'titulo' => $faker->sentence,
                    'conteudo' => $faker->paragraph,
                    'data_hora' => $faker->dateTimeBetween('-1 year', 'now'),
                    'lida' => $faker->boolean,
                ]);
            }
        }

        // 22. Criar Votações (Reduzido de 4 para 3)
        $votacoes = [];
        for ($i = 1; $i <= 3; $i++) {
            $votacoes[] = Votacao::create([
                'titulo' => $faker->sentence,
                'descricao' => $faker->paragraph,
                'data_inicio' => $faker->dateTimeBetween('-1 month', 'now'),
                'data_fim' => $faker->dateTimeBetween('now', '+1 month'),
                'quorum_minimo' => $faker->numberBetween(10, 50),
                'status' => $faker->randomElement(['Aberta', 'Fechada']),
            ]);
        }

        // 23. Criar Opções de Votação (Mantido 3 por votação)
        $opcoes = [];
        foreach ($votacoes as $votacao) {
            for ($i = 1; $i <= 3; $i++) {
                $opcoes[] = OpcaoVotacao::create([
                    'votacao_id' => $votacao->id,
                    'descricao' => $faker->sentence,
                ]);
            }
        }

        // 24. Criar Votos (Reduzido probabilidade de 50% para 35%)
        foreach ($votacoes as $votacao) {
            foreach ($users as $user) {
                if ($faker->boolean(35)) { // 35% chance de votar (reduzido de 50%)
                    Voto::create([
                        'votacao_id' => $votacao->id,
                        'user_id' => $user->id,
                        'opcao_id' => $faker->randomElement($opcoes)->id,
                        'data_hora' => $faker->dateTimeBetween($votacao->data_inicio, $votacao->data_fim),
                        'hash_voto' => $faker->sha256,
                    ]);
                }
            }
        }
    }
}