@php
    $uniqueId = isset($alocacao_material) && $alocacao_material->id ? $alocacao_material->id : 'new';
@endphp

<div class="row mb-3">
    <div class="form-group mb-3">
        <input type="hidden" name="id" id="id_{{ $uniqueId }}" value="{{ old('id', $alocacao_material->id ?? '') }}">
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_triagem_{{ $uniqueId }}">Triagem</label>
        <select class="form-control select2 @error('it_id_triagem') is-invalid @enderror" 
                id="it_id_triagem_{{ $uniqueId }}"
                name="it_id_triagem">
            <option value="">Selecione uma triagem (opcional)</option>
            @foreach ($triagems as $triagem)
                <option value="{{ $triagem->id }}"
                    {{ old('it_id_triagem', $alocacao_material->it_id_triagem ?? '') == $triagem->id ? 'selected' : '' }}>
                    ID: {{ $triagem->id }} - {{ $triagem->dt_triagem }}
                </option>
            @endforeach
        </select>
        @error('it_id_triagem')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_consulta_{{ $uniqueId }}">Consulta</label>
        <select class="form-control select2 @error('it_id_consulta') is-invalid @enderror" 
                id="it_id_consulta_{{ $uniqueId }}"
                name="it_id_consulta">
            <option value="">Selecione uma consulta (opcional)</option>
            @foreach ($consultas as $consulta)
                <option value="{{ $consulta->id }}"
                    {{ old('it_id_consulta', $alocacao_material->it_id_consulta ?? '') == $consulta->id ? 'selected' : '' }}>
                    ID: {{ $consulta->id }} - {{ $consulta->dt_consulta ?? 'Sem data' }}
                </option>
            @endforeach
        </select>
        @error('it_id_consulta')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_produto_{{ $uniqueId }}">Produto <b style="color: red;"> *</b></label>
        <select class="form-control select2 @error('it_id_produto') is-invalid @enderror" 
                id="it_id_produto_{{ $uniqueId }}"
                name="it_id_produto" required>
            <option value="">Selecione um produto</option>
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}"
                    {{ old('it_id_produto', $alocacao_material->it_id_produto ?? '') == $produto->id ? 'selected' : '' }}>
                    {{ $produto->vc_nome }}
                </option>
            @endforeach
        </select>
        @error('it_id_produto')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_alocacao_{{ $uniqueId }}">Alocação <b style="color: red;"> *</b></label>
        <select class="form-control select2 @error('it_id_alocacao') is-invalid @enderror" 
                id="it_id_alocacao_{{ $uniqueId }}"
                name="it_id_alocacao" required>
            <option value="">Selecione uma alocação</option>
            @foreach ($alocacaos as $alocacao)
                <option value="{{ $alocacao->id }}"
                    {{ old('it_id_alocacao', $alocacao_material->it_id_alocacao ?? '') == $alocacao->id ? 'selected' : '' }}>
                    ID: {{ $alocacao->id }} - {{ $alocacao->local->vc_nome ?? 'Local não disponível' }}
                </option>
            @endforeach
        </select>
        @error('it_id_alocacao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_quantidade_{{ $uniqueId }}">Quantidade <b style="color: red;"> *</b></label>
        <input type="number" class="form-control @error('it_quantidade') is-invalid @enderror" 
               id="it_quantidade_{{ $uniqueId }}"
               name="it_quantidade" required min="1"
               value="{{ old('it_quantidade', $alocacao_material->it_quantidade ?? '') }}">
        @error('it_quantidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="vc_unidade_{{ $uniqueId }}">Unidade de Medida <b style="color: red;"> *</b></label>
        <input type="text" class="form-control @error('vc_unidade') is-invalid @enderror" 
               id="vc_unidade_{{ $uniqueId }}"
               name="vc_unidade" required 
               value="{{ old('vc_unidade', $alocacao_material->vc_unidade ?? '') }}"
               placeholder="Ex: unidades, caixas, ml, g, etc.">
        @error('vc_unidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="vc_motivo_{{ $uniqueId }}">Motivo <b style="color: red;"> *</b></label>
        <input type="text" class="form-control @error('vc_motivo') is-invalid @enderror" 
               id="vc_motivo_{{ $uniqueId }}"
               name="vc_motivo" required 
               value="{{ old('vc_motivo', $alocacao_material->vc_motivo ?? '') }}">
        @error('vc_motivo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_unidade_{{ $uniqueId }}">Unidade <b style="color: red;"> *</b></label>
        <select class="form-control select2 @error('it_id_unidade') is-invalid @enderror" 
                id="it_id_unidade_{{ $uniqueId }}"
                name="it_id_unidade" required>
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}"
                    {{ old('it_id_unidade', $alocacao_material->it_id_unidade ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->vc_nome }}
                </option>
            @endforeach
        </select>
        @error('it_id_unidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Selecione uma opção',
            width: '100%'
        });
    });
</script>