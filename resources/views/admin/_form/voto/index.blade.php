<div class="row">
    <div class="col-md-6 mb-3">
        <label for="votacao_id">Votação</label>
        <select class="form-control select2" id="votacao_id" name="votacao_id" required>
            <option value="">Selecione uma votação</option>
            @foreach ($votacaos as $votacao)
                <option value="{{ $votacao->id }}" {{ old('votacao_id', $voto->votacao_id ?? '') == $votacao->id ? 'selected' : '' }}>
                    {{ $votacao->titulo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="user_id">Usuário</label>
        <select class="form-control select2" id="user_id" name="user_id" required>
            <option value="">Selecione um usuário</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $voto->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="opcao_id">Opção</label>
        <select class="form-control select2" id="opcao_id" name="opcao_id" required>
            <option value="">Selecione uma opção</option>
            @foreach ($opcaoVotacaos as $opcaoVotacao)
                <option value="{{ $opcaoVotacao->id }}" {{ old('opcao_id', $voto->opcao_id ?? '') == $opcaoVotacao->id ? 'selected' : '' }}>
                    {{ $opcaoVotacao->descricao }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_hora">Data/Hora</label>
        <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" value="{{ old('data_hora', $voto->data_hora ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="hash_voto">Hash Voto</label>
        <input type="text" class="form-control" id="hash_voto" name="hash_voto" value="{{ old('hash_voto', $voto->hash_voto ?? '') }}">
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