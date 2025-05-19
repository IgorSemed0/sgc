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
     * Ajustado para gerar 10 registros por entidade e apenas 1 conta.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_PT');

        // 1. Criar Blocos (10)
        $blocos = [];
        for ($i = 1; $i <= 10; $i++) {
            $blocos[] = Bloco::create([
                'nome' => "Bloco {$i}",
                'descricao' => "Bloco {$i} residencial",
            ]);
        }

        // 2. Criar Edifícios (1 por bloco = 10)
        $edificios = [];
        foreach ($blocos as $bloco) {
            $edificios[] = Edificio::create([
                'nome' => "Edifício 1",
                'descricao' => "Edifício 1 do {$bloco->nome}",
                'bloco_id' => $bloco->id,
            ]);
        }

        // 3. Criar Unidades (10 por edifício = 100)
        $unidades = [];
        $tiposUnidade = ['Apartamento', 'Sala Comercial', 'Casa'];
        $statusUnidade = ['alugada', 'disponivel'];
        foreach ($edificios as $edificio) {
            for ($i = 1; $i <= 10; $i++) {
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

        // 4. Criar Usuários (10)
        $users = [];
        $tiposUsuario = ['admin', 'morador', 'funcionario'];
        for ($i = 1; $i <= 10; $i++) {
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

        // 5. Criar Departamentos (10)
        $departamentos = [];
        $nomesDepartamentos = ['Administração', 'Segurança', 'Limpeza', 'Manutenção', 'Financeiro', 'RH', 'TI', 'Jardim', 'Portaria', 'Eventos'];
        foreach ($nomesDepartamentos as $nome) {
            $departamentos[] = Departamento::create([
                'nome' => $nome,
                'descricao' => "Departamento de {$nome}",
            ]);
        }

        // 6. Criar Moradores (~10% das unidades para ~10 moradores)
        $moradores = [];
        $tiposMorador = ['proprietario', 'inquilino', 'dependente'];
        $inquilinosPorUnidade = [];
        $unidadesSelecionadas = $faker->randomElements($unidades, min(10, count($unidades)));
        foreach ($unidadesSelecionadas as $unidade) {
            $tipo = $faker->randomElement($tiposMorador);
            $dependenteDe = null;
            if ($tipo == 'dependente') {
                if (isset($inquilinosPorUnidade[$unidade->id]) && !empty($inquilinosPorUnidade[$unidade->id])) {
                    $dependenteDe = $faker->randomElement($inquilinosPorUnidade[$unidade->id]);
                } else {
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
                    $moradores[] = $inquilino;
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

        // 7. Criar Funcionários (1 por departamento = 10)
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

        // 8. Criar Visitantes (~10% das unidades para ~10 visitantes)
        $visitantes = [];
        $unidadesSelecionadas = $faker->randomElements($unidades, min(10, count($unidades)));
        foreach ($unidadesSelecionadas as $unidade) {
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

        // 9. Criar Acessos (10 no total, distribuídos entre entidades)
        $acessos = [];
        $entidades = array_merge(
            array_map(fn($m) => ['id' => $m->id, 'tipo' => 'Morador'], $moradores),
            array_map(fn($f) => ['id' => $f->id, 'tipo' => 'Funcionario'], $funcionarios),
            array_map(fn($v) => ['id' => $v->id, 'tipo' => 'Visitante'], $visitantes)
        );
        $entidadesSelecionadas = $faker->randomElements($entidades, min(10, count($entidades)));
        foreach ($entidadesSelecionadas as $entidade) {
            $acessos[] = Acesso::create([
                'entidade_id' => $entidade['id'],
                'tipo_pessoa' => $entidade['tipo'],
                'data_hora' => $faker->dateTimeBetween('-1 year', 'now'),
                'tipo' => $faker->randomElement(['Entrada', 'Saída']),
                'observacao' => $faker->sentence,
            ]);
        }

        // 10. Criar Conta (1)
        $conta = Conta::create([
            'nome' => "Conta Principal",
            'tipo' => 'Corrente',
            'saldo' => $faker->numberBetween(10000, 100000),
        ]);

        // 11. Criar Movimentos (10 para a conta)
        for ($i = 1; $i <= 10; $i++) {
            Movimento::create([
                'conta_id' => $conta->id,
                'tipo' => $faker->randomElement(['Crédito', 'Débito']),
                'valor' => $faker->numberBetween(100, 5000),
                'descricao' => $faker->sentence,
                'data_movimento' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 12. Criar Despesas (10)
        for ($i = 1; $i <= 10; $i++) {
            Despesa::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(500, 10000),
                'data_despesa' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 13. Criar Rupes (10)
        for ($i = 1; $i <= 10; $i++) {
            Rupe::create([
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(1000, 20000),
                'data_receita' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 14. Criar Facturas (~10% das unidades para ~10 facturas)
        $facturas = [];
        $unidadesSelecionadas = $faker->randomElements($unidades, min(10, count($unidades)));
        foreach ($unidadesSelecionadas as $unidade) {
            $facturas[] = Factura::create([
                'unidade_id' => $unidade->id,
                'referencia' => $faker->numerify('F#####'),
                'data_emissao' => $faker->dateTimeBetween('-1 year', 'now'),
                'data_vencimento' => $faker->dateTimeBetween('now', '+1 month'),
                'valor_total' => $faker->numberBetween(1000, 5000),
                'status' => $faker->randomElement(['Pendente', 'Pago', 'Cancelado']),
            ]);
        }

        // 15. Criar Factura Items (1 por factura = 10)
        foreach ($facturas as $factura) {
            FacturaItem::create([
                'factura_id' => $factura->id,
                'categoria' => $faker->randomElement(['Água', 'Energia', 'Manutenção']),
                'descricao' => $faker->sentence,
                'valor' => $faker->numberBetween(200, 2000),
            ]);
        }

        // 16. Criar Pagamentos (~50% de facturas pagas para ~5 pagamentos)
        $pagamentos = [];
        $facturasPagas = array_filter($facturas, fn($f) => $f->status === 'Pago');
        $facturasSelecionadas = $faker->randomElements($facturasPagas, min(5, count($facturasPagas)));
        foreach ($facturasSelecionadas as $factura) {
            $pagamentos[] = Pagamento::create([
                'factura_id' => $factura->id,
                'data_pagamento' => $faker->dateTimeBetween($factura->data_emissao, 'now'),
                'valor_pago' => $factura->valor_total,
                'metodo_pagamento' => $faker->randomElement(['Multicaixa', 'Transferência', 'Dinheiro']),
            ]);
        }

        // 17. Criar Espaços Comuns (10)
        $espacosComuns = [];
        for ($i = 1; $i <= 10; $i++) {
            $espacosComuns[] = EspacoComum::create([
                'nome' => $faker->randomElement(['Piscina', 'Salão de Festas', 'Ginásio', 'Churrasqueira', 'Playground']),
                'descricao' => $faker->sentence,
                'bloco_id' => $faker->randomElement($blocos)->id,
                'regras' => $faker->paragraph,
            ]);
        }

        // 18. Criar Reservas de Espaços (1 por espaço = 10)
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

        // 19. Criar Chat Posts (10)
        $chatPosts = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = $faker->randomElement($users);
            $chatPosts[] = ChatPost::create([
                'autor_id' => $user->id,
                'tipo_autor' => $user->tipo_usuario,
                'titulo' => $faker->sentence,
                'conteudo' => $faker->paragraph,
                'data_publicacao' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

        // 20. Criar Chat Comentários (1 por post = 10)
        foreach ($chatPosts as $post) {
            ChatComentario::create([
                'post_id' => $post->id,
                'user_id' => $faker->randomElement($users)->id,
                'conteudo' => $faker->sentence,
                'data_comentario' => $faker->dateTimeBetween($post->data_publicacao, 'now'),
            ]);
        }

        // 21. Criar Notificações (1 por usuário = 10)
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

        // 22. Criar Votações (10)
        $votacoes = [];
        for ($i = 1; $i <= 10; $i++) {
            $votacoes[] = Votacao::create([
                'titulo' => $faker->sentence,
                'descricao' => $faker->paragraph,
                'data_inicio' => $faker->dateTimeBetween('-1 month', 'now'),
                'data_fim' => $faker->dateTimeBetween('now', '+1 month'),
                'quorum_minimo' => $faker->numberBetween(10, 50),
                'status' => $faker->randomElement(['Aberta', 'Fechada']),
            ]);
        }

        // 23. Criar Opções de Votação (1 por votação = 10)
        $opcoes = [];
        foreach ($votacoes as $votacao) {
            $opcoes[] = OpcaoVotacao::create([
                'votacao_id' => $votacao->id,
                'descricao' => $faker->sentence,
            ]);
        }

        // 24. Criar Votos (~50% dos usuários por votação para ~50 votos)
        $votos = [];
        foreach ($votacoes as $votacao) {
            $usuariosSelecionados = $faker->randomElements($users, min(5, count($users)));
            foreach ($usuariosSelecionados as $user) {
                $votos[] = Voto::create([
                    'votacao_id' => $votacao->id,
                    'user_id' => $user->id,
                    'opcao_id' => $opcoes[array_search($votacao, $votacoes)]->id,
                    'data_hora' => $faker->dateTimeBetween($votacao->data_inicio, $votacao->data_fim),
                    'hash_voto' => $faker->sha256,
                ]);
            }
        }
    }
}