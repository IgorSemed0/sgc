@php
    $uniqueId = isset($alocacao) && $alocacao->id ? $alocacao->id : 'new';
@endphp

<div class="row mb-3">
    <div class="form-group mb-3">
        <input type="hidden" name="id" id="id_{{ $uniqueId }}" value="{{ old('id', $alocacao->id ?? '') }}">
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_especialidade_{{ $uniqueId }}">Especialidade</label>
        <select class="form-control select2 @error('it_id_especialidade') is-invalid @enderror" 
                id="it_id_especialidade_{{ $uniqueId }}"
                name="it_id_especialidade">
            <option value="">Selecione uma especialidade (opcional)</option>
            @foreach ($especialidades as $especialidade)
                <option value="{{ $especialidade->id }}"
                    {{ old('it_id_especialidade', $alocacao->it_id_especialidade ?? '') == $especialidade->id ? 'selected' : '' }}>
                    {{ $especialidade->vc_nome }}
                </option>
            @endforeach
        </select>
        @error('it_id_especialidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_local_{{ $uniqueId }}">Local <b style="color: red;"> *</b></label>
        <select class="form-control select2 @error('it_id_local') is-invalid @enderror" 
                id="it_id_local_{{ $uniqueId }}"
                name="it_id_local" required>
            <option value="">Selecione um local</option>
            @foreach ($locals as $local)
                <option value="{{ $local->id }}"
                    {{ old('it_id_local', $alocacao->it_id_local ?? '') == $local->id ? 'selected' : '' }}>
                    {{ $local->vc_nome }} - {{ $local->vc_tipo }}
                </option>
            @endforeach
        </select>
        @error('it_id_local')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="it_id_subsector_{{ $uniqueId }}">Subsector <b style="color: red;"> *</b></label>
        <select class="form-control select2 @error('it_id_subsector') is-invalid @enderror" 
                id="it_id_subsector_{{ $uniqueId }}"
                name="it_id_subsector" required>
            <option value="">Selecione um subsector</option>
            @foreach ($subsectors as $subsector)
                <option value="{{ $subsector->id }}"
                    {{ old('it_id_subsector', $alocacao->it_id_subsector ?? '') == $subsector->id ? 'selected' : '' }}>
                    {{ $subsector->vc_nome }}
                </option>
            @endforeach
        </select>
        @error('it_id_subsector')
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
                    {{ old('it_id_unidade', $alocacao->it_id_unidade ?? '') == $unidade->id ? 'selected' : '' }}>
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