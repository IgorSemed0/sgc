<div class="row">
    <div class="col-md-6 mb-3">
        <label for="espaco_id">Espaço Comum</label>
        <select class="form-control select2" id="espaco_id" name="espaco_id" required>
            <option value="">Selecione um espaço comum</option>
            @foreach ($espacoComums as $espacoComum)
                <option value="{{ $espacoComum->id }}" {{ old('espaco_id', $espacoReserva->espaco_id ?? '') == $espacoComum->id ? 'selected' : '' }}>
                    {{ $espacoComum->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="user_id">Usuário</label>
        <select class="form-control select2" id="user_id" name="user_id" required>
            <option value="">Selecione um usuário</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $espacoReserva->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_reserva">Data Reserva</label>
        <input type="date" class="form-control" id="data_reserva" name="data_reserva" value="{{ old('data_reserva', $espacoReserva->data_reserva ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="hora_inicio">Hora Início</label>
        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', $espacoReserva->hora_inicio ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="hora_fim">Hora Fim</label>
        <input type="time" class="form-control" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', $espacoReserva->hora_fim ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="status">Status</label>
        <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $espacoReserva->status ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="observacao">Observação</label>
        <input type="text" class="form-control" id="observacao" name="observacao" value="{{ old('observacao', $espacoReserva->observacao ?? '') }}">
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