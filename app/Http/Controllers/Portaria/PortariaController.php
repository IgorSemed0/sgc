<?php

namespace App\Http\Controllers\Portaria;

use App\Http\Controllers\Controller;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Visitante;
use App\Models\Acesso;
use App\Models\Unidade;
use App\Models\Condominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortariaController extends Controller
{
    public function index()
    {
        $acessos = Acesso::orderBy('data_hora', 'desc')
                        ->take(10)
                        ->get();

        $unidades = Unidade::all();
        $condominios = Condominio::all();
        
        return view('portaria.index', compact('acessos', 'unidades', 'condominios'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'bi' => 'required|string',
        ]);

        $bi = $validated['bi'];

        $morador = Morador::where('bi', $bi)->first();
        if ($morador) {
            return response()->json(['type' => 'morador', 'data' => $morador]);
        }

        $funcionario = Funcionario::where('bi', $bi)->first();
        if ($funcionario) {
            return response()->json(['type' => 'funcionario', 'data' => $funcionario]);
        }

        $visitante = Visitante::where('bi', $bi)->first();
        if ($visitante) {
            return response()->json(['type' => 'visitante', 'data' => $visitante]);
        }

        return response()->json(['type' => 'not_found', 'message' => 'Pessoa não encontrada. Registre como novo visitante.']);
    }

    public function searchByName(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2',
        ]);

        $searchTerm = $validated['name'];
        
        \Log::info("Busca de pessoa iniciada com termo: " . $searchTerm);
        
        // Normalize search term: remove accents, convert to lowercase
        $normalizedSearch = $this->normalizeString($searchTerm);
        
        // Split search term into words
        $searchWords = array_filter(explode(' ', $normalizedSearch));
        
        // If we have less than 2 characters and no multiple words, enforce minimum character limit
        if (strlen($normalizedSearch) < 3 && count($searchWords) < 2) {
            return response()->json([
                'results' => [],
                'message' => 'Digite pelo menos 3 caracteres para pesquisar'
            ]);
        }

        // Search in all types of people
        $moradores = $this->searchPessoas(Morador::with(['unidade.bloco']), $searchTerm, 'morador');
        $funcionarios = $this->searchPessoas(Funcionario::query(), $searchTerm, 'funcionario');
        $visitantes = $this->searchPessoas(Visitante::with(['unidade']), $searchTerm, 'visitante');
        
        // Combine and sort results by score
        $allResults = array_merge($moradores, $funcionarios, $visitantes);
        
        usort($allResults, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Limit to top 10 results
        $results = array_slice($allResults, 0, 10);
        
        return response()->json(['results' => $results]);
    }
    
    /**
     * Search for pessoas of a specific type
     * 
     * @param Builder $query The query builder
     * @param string $searchTerm The search term
     * @param string $tipo The type of pessoa (morador, funcionario, visitante)
     * @return array Results with scores
     */
    private function searchPessoas($query, $searchTerm, $tipo)
    {
        $normalizedSearch = $this->normalizeString($searchTerm);
        $searchWords = array_filter(explode(' ', $normalizedSearch));
        
        $pessoas = $query->get();
        $results = [];
        
        foreach ($pessoas as $pessoa) {
            // Create full name
            $fullName = trim($pessoa->primeiro_nome . ' ' . 
                   ($pessoa->nomes_meio ? $pessoa->nomes_meio . ' ' : '') . 
                   $pessoa->ultimo_nome);
                   
            // Normalize name for comparison
            $normalizedName = $this->normalizeString($fullName);
            
            // Calculate match score
            $score = $this->calculateNameMatchScore($normalizedName, $normalizedSearch, $searchWords);
            
            // If we have a match, add to results with score
            if ($score > 0) {
                // Add additional info based on type
                if ($tipo === 'morador' && $pessoa->unidade) {
                    $blocoName = $pessoa->unidade->bloco ? $pessoa->unidade->bloco->nome : 'N/A';
                    $pessoa->additional_info = "U{$pessoa->unidade->numero} - {$blocoName}";
                } elseif ($tipo === 'visitante' && $pessoa->unidade) {
                    $pessoa->additional_info = "U{$pessoa->unidade->numero}";
                } else {
                    $pessoa->additional_info = '';
                }
                
                $results[] = [
                    'id' => $pessoa->id,
                    'nome' => $fullName,
                    'tipo' => $tipo,
                    'bi' => $pessoa->bi ?? 'Não informado',
                    'additional_info' => $pessoa->additional_info,
                    'score' => $score,
                    'telefone' => $pessoa->telefone ?? 'Não informado',
                    'email' => $pessoa->email ?? 'Não informado'
                ];
            }
        }
        
        return $results;
    }

    public function searchMorador(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2',
        ]);

        $searchTerm = $validated['name'];
        
        // Log para debug
        \Log::info("Busca de morador iniciada com termo: " . $searchTerm);
        
        // Normalize search term: remove accents, convert to lowercase
        $normalizedSearch = $this->normalizeString($searchTerm);
        
        // Split search term into words
        $searchWords = array_filter(explode(' ', $normalizedSearch));
        
        // If we have less than 2 characters and no multiple words, enforce minimum 3 characters
        if (strlen($normalizedSearch) < 3 && count($searchWords) < 2) {
            return response()->json([
                'moradores' => [],
                'message' => 'Digite pelo menos 3 caracteres para pesquisar'
            ]);
        }

        // Debug: Verificar quantidade total de moradores no sistema
        $totalMoradores = Morador::withTrashed()->count();
        $activeMoradores = Morador::count();
        \Log::info("Total de moradores (incluindo deletados): $totalMoradores, Ativos: $activeMoradores");

        // Get candidate moradores (incluindo todos os tipos)
        // Removemos o filtro por tipo para verificar se é por isso que não está retornando resultados
        $moradores = Morador::with(['unidade.bloco'])->get();
        
        \Log::info("Moradores encontrados para processamento: " . $moradores->count());
        
        $results = [];
        
        foreach ($moradores as $morador) {
            // Verificar os dados do morador para debug
            \Log::debug("Verificando morador ID: {$morador->id}, Nome: {$morador->primeiro_nome} {$morador->ultimo_nome}, Tipo: {$morador->tipo}");
            
            // Create the full name for each morador
            $fullName = trim($morador->primeiro_nome . ' ' . 
                       ($morador->nomes_meio ? $morador->nomes_meio . ' ' : '') . 
                       $morador->ultimo_nome);
                       
            // Normalize morador name for comparison
            $normalizedName = $this->normalizeString($fullName);
            
            // Calculate match score
            $score = $this->calculateNameMatchScore($normalizedName, $normalizedSearch, $searchWords);
            
            \Log::debug("Nome: $fullName, Score: $score");
            
            // If we have a match, add to results with score
            if ($score > 0) {
                // Add unit info
                if ($morador->unidade) {
                    $blocoName = $morador->unidade->bloco ? $morador->unidade->bloco->nome : 'N/A';
                    $morador->unidade_info = "U{$morador->unidade->numero} - {$blocoName}";
                } else {
                    $morador->unidade_info = 'Não associado';
                }
                
                \Log::info("Match encontrado: $fullName com score $score");
                
                $results[] = [
                    'morador' => $morador,
                    'score' => $score
                ];
            }
        }
        
        \Log::info("Total de resultados encontrados: " . count($results));
        
        // Sort results by score (highest first)
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Limit to top 10 results
        $results = array_slice($results, 0, 10);
        
        // Extract just moradores from results
        $moradores = array_map(function($item) {
            return $item['morador'];
        }, $results);

        return response()->json(['moradores' => $moradores]);
    }
    
    /**
     * Normalize string for better comparison
     * Removes accents, converts to lowercase, and removes extra spaces
     */
    private function normalizeString($string)
    {
        // Convert to ASCII (remove accents)
        $string = Str::ascii($string);
        
        // Convert to lowercase
        $string = strtolower($string);
        
        // Remove extra spaces
        $string = preg_replace('/\s+/', ' ', trim($string));
        
        return $string;
    }
    
    /**
     * Calculate a match score between a name and search term
     * Returns 0 if no match, otherwise a score with higher being better match
     */
    private function calculateNameMatchScore($fullName, $searchTerm, $searchWords)
    {
        $score = 0;
        
        // Check for exact match (highest priority)
        if ($fullName === $searchTerm) {
            return 100;
        }
        
        // Check for full name starting with search term
        if (str_starts_with($fullName, $searchTerm)) {
            $score += 80;
        }
        // Check if full name contains search term
        elseif (str_contains($fullName, $searchTerm)) {
            $score += 60;
        }
        
        // If no basic match found, score is 0
        if ($score === 0) {
            // Check individual words
            $nameWords = explode(' ', $fullName);
            
            // Check for matches in individual words
            foreach ($searchWords as $searchWord) {
                // Skip very short words unless exact matches
                if (strlen($searchWord) < 3) {
                    foreach ($nameWords as $nameWord) {
                        if ($nameWord === $searchWord) {
                            $score += 40;
                        }
                    }
                    continue;
                }
                
                $wordMatchFound = false;
                
                foreach ($nameWords as $nameWord) {
                    // Exact word match
                    if ($nameWord === $searchWord) {
                        $score += 50;
                        $wordMatchFound = true;
                        break;
                    }
                    
                    // Name word starts with search word
                    if (str_starts_with($nameWord, $searchWord)) {
                        $score += 30;
                        $wordMatchFound = true;
                        break;
                    }
                    
                    // Search word starts with name word
                    if (str_starts_with($searchWord, $nameWord)) {
                        $score += 20;
                        $wordMatchFound = true;
                        break;
                    }
                    
                    // Contains the word
                    if (str_contains($nameWord, $searchWord)) {
                        $score += 10;
                        $wordMatchFound = true;
                        break;
                    }
                }
                
                // If we didn't find a match for this word, penalize the score
                if (!$wordMatchFound) {
                    $score -= 5;
                }
            }
        }
        
        return max(0, $score);
    }

    public function registerAccess(Request $request)
    {
        $validated = $request->validate([
            'entidade_id' => 'required|integer',
            'tipo_pessoa' => 'required|in:morador,funcionario,visitante',
            'tipo' => 'required|in:Entrada,Saida',
            'observacao' => 'nullable|string',
        ]);
        
        $entidadeId = $validated['entidade_id'];
        $tipoPessoa = $validated['tipo_pessoa'];
        $tipoAcesso = $validated['tipo'];
        
        // Check if we can register this access type
        $canRegister = $this->canRegisterAccess($entidadeId, $tipoPessoa, $tipoAcesso);
        
        if (!$canRegister['allowed']) {
            return redirect()->back()->with('error', $canRegister['message']);
        }
        
        $validated['data_hora'] = now();

        try {
            Acesso::create([
                'entidade_id' => $validated['entidade_id'],
                'tipo_pessoa' => $validated['tipo_pessoa'],
                'tipo' => $validated['tipo'],
                'data_hora' => $validated['data_hora'],
                'observacao' => $validated['observacao'],
            ]);

            return redirect()->route('portaria.index')->with('success', 'Acesso registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao registrar acesso: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if we can register the requested access type
     * 
     * @param int $entidadeId The ID of the entity
     * @param string $tipoPessoa The type of person (morador, funcionario, visitante)
     * @param string $tipoAcesso The type of access (Entrada, Saida)
     * @return array Array with 'allowed' boolean and 'message' string
     */
    private function canRegisterAccess($entidadeId, $tipoPessoa, $tipoAcesso)
    {
        // Get the last access for this entity
        $lastAccess = Acesso::where('entidade_id', $entidadeId)
                           ->where('tipo_pessoa', $tipoPessoa)
                           ->orderBy('data_hora', 'desc')
                           ->first();
        
        // If no previous access, only allow entry (Entrada)
        if (!$lastAccess) {
            if ($tipoAcesso === 'Entrada') {
                return ['allowed' => true, 'message' => ''];
            } else {
                return [
                    'allowed' => false, 
                    'message' => 'Não é possível registrar uma saída sem uma entrada prévia.'
                ];
            }
        }
        
        // If the last access was an entry (Entrada), only allow exit (Saida)
        if ($lastAccess->tipo === 'Entrada' && $tipoAcesso === 'Entrada') {
            return [
                'allowed' => false, 
                'message' => 'Esta pessoa já tem uma entrada registrada. É necessário registrar a saída antes de uma nova entrada.'
            ];
        }
        
        // If the last access was an exit (Saida), only allow entry (Entrada)
        if ($lastAccess->tipo === 'Saida' && $tipoAcesso === 'Saida') {
            return [
                'allowed' => false, 
                'message' => 'Esta pessoa já tem uma saída registrada. É necessário registrar a entrada antes de uma nova saída.'
            ];
        }
        
        // Otherwise, the requested access type is valid
        return ['allowed' => true, 'message' => ''];
    }

    public function storeVisitante(Request $request)
    {
        $validated = $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'nomes_meio' => 'nullable|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'bi' => 'nullable|string|max:255|unique:visitantes',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:255',
            'motivo_visita' => 'required|string',
            'unidade_id' => 'nullable|exists:unidades,id',
        ]);

        try {
            $visitante = Visitante::create($validated);

            Acesso::create([
                'entidade_id' => $visitante->id,
                'tipo_pessoa' => 'visitante',
                'tipo' => 'Entrada',
                'data_hora' => now(),
                'observacao' => 'Novo visitante registrado.',
            ]);

            return redirect()->route('portaria.index')->with('success', 'Visitante registrado e acesso de entrada criado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao registrar visitante: ' . $e->getMessage())->withInput();
        }
    }

    public function confirmVisit(Request $request)
    {
        $validated = $request->validate([
            'morador_id' => 'required|integer|exists:moradors,id',
        ]);

        try {
            // You can add any additional logic here to record that the visit was confirmed
            // For example, you might want to add an entry to a visits log or update a status

            return response()->json(['success' => true, 'message' => 'Visita confirmada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}