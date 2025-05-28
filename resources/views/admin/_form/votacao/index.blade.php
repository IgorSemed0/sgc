@php
    $uniqueId = $uniqueId ?? 'new';
    $isEditing = $uniqueId !== 'new';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="titulo_{{ $uniqueId }}">Título</label>
        <input type="text" class="form-control" id="titulo_{{ $uniqueId }}" name="titulo" 
               value="{{ old('titulo', $isEditing ? $votacao->titulo : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="descricao_{{ $uniqueId }}">Descrição</label>
        <textarea class="form-control" id="descricao_{{ $uniqueId }}" name="descricao" required>{{ old('descricao', $isEditing ? $votacao->descricao : '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_inicio_{{ $uniqueId }}">Data Início</label>
        <input type="datetime-local" class="form-control" id="data_inicio_{{ $uniqueId }}" name="data_inicio" 
               value="{{ old('data_inicio', $isEditing ? $votacao->data_inicio : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_fim_{{ $uniqueId }}">Data Fim</label>
        <input type="datetime-local" class="form-control" id="data_fim_{{ $uniqueId }}" name="data_fim" 
               value="{{ old('data_fim', $isEditing ? $votacao->data_fim : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quorum_minimo_{{ $uniqueId }}">Quórum Mínimo</label>
        <input type="number" class="form-control" id="quorum_minimo_{{ $uniqueId }}" name="quorum_minimo" 
               value="{{ old('quorum_minimo', $isEditing ? $votacao->quorum_minimo : '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="status_{{ $uniqueId }}">Status</label>
        <select class="form-control" id="status_{{ $uniqueId }}" name="status" required>
            <option value="">Selecione o status</option>
            <option value="ativa" {{ old('status', $isEditing ? $votacao->status : '') == 'ativa' ? 'selected' : '' }}>Ativa</option>
            <option value="inativa" {{ old('status', $isEditing ? $votacao->status : '') == 'inativa' ? 'selected' : '' }}>Inativa</option>
            <option value="finalizada" {{ old('status', $isEditing ? $votacao->status : '') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
        </select>
    </div>
    
    <!-- Voting Options Section -->
    <div class="col-12 mb-3">
        <label class="form-label">Opções de Votação</label>
        <div id="opcoes_container_{{ $uniqueId }}">
            @php
                $opcoes = old('opcoes', $isEditing && $votacao->opcaoVotacaos ? $votacao->opcaoVotacaos->pluck('descricao')->toArray() : ['', '']);
                if (empty($opcoes)) {
                    $opcoes = ['', '']; // Default 2 empty options
                }
            @endphp
            
            @foreach($opcoes as $index => $opcao)
                <div class="opcao-item mb-2 d-flex">
                    <div class="flex-grow-1 me-2">
                        <input type="text" 
                               class="form-control" 
                               name="opcoes[]" 
                               value="{{ $opcao }}" 
                               placeholder="Digite a opção de votação {{ $index + 1 }}"
                               required>
                    </div>
                    @if($index >= 2)
                        <button type="button" class="btn btn-danger btn-sm remove-opcao">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
        
        <button type="button" id="add_opcao_{{ $uniqueId }}" class="btn btn-success btn-sm mt-2">
            <i class="fas fa-plus"></i> Adicionar Opção
        </button>
        
        <small class="form-text text-muted">
            Mínimo de 2 opções necessárias para a votação.
        </small>
    </div>
</div>

<script>
    $(document).ready(function() {
        const uniqueId = '{{ $uniqueId }}';
        const opcoesContainer = $('#opcoes_container_' + uniqueId);
        const addOpcaoButton = $('#add_opcao_' + uniqueId);

        let opcaoCounter = opcoesContainer.find('.opcao-item').length;

        // Add new voting option
        addOpcaoButton.on('click', function() {
            opcaoCounter++;
            const newOpcao = `
                <div class="opcao-item mb-2 d-flex">
                    <div class="flex-grow-1 me-2">
                        <input type="text" 
                               class="form-control" 
                               name="opcoes[]" 
                               placeholder="Digite a opção de votação ${opcaoCounter}"
                               required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-opcao">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            opcoesContainer.append(newOpcao);
        });

        // Remove voting option - using event delegation
        opcoesContainer.on('click', '.remove-opcao', function() {
            if (opcoesContainer.find('.opcao-item').length > 2) {
                $(this).closest('.opcao-item').remove();
                opcaoCounter--;
            } else {
                alert('É necessário ter pelo menos 2 opções de votação.');
            }
        });

        // Form validation - target the specific form containing this uniqueId
        const form = $('#opcoes_container_' + uniqueId).closest('form');
        form.on('submit', function(e) {
            const opcoes = $(this).find('input[name="opcoes[]"]').map(function() {
                return $(this).val().trim();
            }).get().filter(function(opcao) {
                return opcao !== ''; // Filter out empty strings
            });

            console.log('Opções encontradas:', opcoes); // Debug log

            if (opcoes.length < 2) {
                e.preventDefault();
                alert('É necessário ter pelo menos 2 opções de votação preenchidas.');
                return false;
            }

            // Check for duplicate options (case insensitive)
            const uniqueOpcoes = [...new Set(opcoes.map(opcao => opcao.toLowerCase()))];
            if (uniqueOpcoes.length !== opcoes.length) {
                e.preventDefault();
                alert('Não é possível ter opções de votação duplicadas.');
                console.log('Opções duplicadas detectadas:', opcoes); // Debug log
                return false;
            }
        });
    });
</script>