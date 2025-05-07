<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome*</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $morador->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $morador->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome*</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $morador->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email*</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $morador->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone*</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $morador->telefone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="data_nascimento">Data de Nascimento*</label>
        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $morador->data_nascimento ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sexo">Sexo*</label>
        <select class="form-control select2" id="sexo" name="sexo" required>
            <option value="">Selecione o sexo</option>
            <option value="Masculino" {{ old('sexo', $morador->sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Feminino" {{ old('sexo', $morador->sexo ?? '') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="Outro" {{ old('sexo', $morador->sexo ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo*</label>
        <select class="form-control select2" id="tipo" name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="proprietario" {{ old('tipo', $morador->tipo ?? '') == 'proprietario' ? 'selected' : '' }}>Proprietário</option>
            <option value="inquilino" {{ old('tipo', $morador->tipo ?? '') == 'inquilino' ? 'selected' : '' }}>Inquilino</option>
            <option value="dependente" {{ old('tipo', $morador->tipo ?? '') == 'dependente' ? 'selected' : '' }}>Dependente</option>
        </select>
    </div>

    <!-- Campo Estado Residente (apenas para proprietário) -->
    <div class="col-md-6 mb-3" id="estado_residente_div" style="display: none;">
        <label for="estado_residente">Residente*</label>
        <select class="form-control select2" id="estado_residente" name="estado_residente" required>
            <option value="1" {{ old('estado_residente', $morador->estado_residente ?? '') == '1' ? 'selected' : '' }}>Sim</option>
            <option value="0" {{ old('estado_residente', $morador->estado_residente ?? '') == '0' ? 'selected' : '' }}>Não</option>
        </select>
    </div>

    <!-- Campo Dependente De (apenas para dependente) -->
    <div class="col-md-6 mb-3" id="dependente_de_div" style="display: none;">
        <label for="dependente_de">Dependente de (Inquilino)*</label>
        <select class="form-control select2" id="dependente_de" name="dependente_de" required>
            <option value="">Selecione o inquilino</option>
            @foreach ($inquilinos as $inquilino)
                <option value="{{ $inquilino->id }}" {{ old('dependente_de', $morador->dependente_de ?? '') == $inquilino->id ? 'selected' : '' }}>
                    {{ $inquilino->primeiro_nome }} {{ $inquilino->ultimo_nome }} - Unidade {{ $inquilino->unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Campo BI ou Cédula -->
    <div class="col-md-6 mb-3" id="bi_div">
        <label for="bi">BI*</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $morador->bi ?? '') }}">
    </div>
    <div class="col-md-6 mb-3" id="cedula_div" style="display: none;">
        <label for="cedula">Cédula*</label>
        <input type="text" class="form-control" id="cedula" name="cedula" value="{{ old('cedula', $morador->cedula ?? '') }}">
    </div>

    <!-- Campo Unidade (não para dependente) -->
    <div class="col-md-6 mb-3" id="unidade_div">
        <label for="unidade_id">Unidade*</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id" required>
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $morador->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->tipo }} - {{ $unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Selecione uma opção',
            width: '100%'
        });

        function adjustFields() {
            var tipo = $('#tipo').val();
            if (tipo == 'proprietario') {
                $('#estado_residente_div').show();
                $('#dependente_de_div').hide();
                $('#unidade_div').show();
                $('#bi_div').show();
                $('#cedula_div').hide();
                $('#bi').prop('required', true);
                $('#cedula').prop('required', false);
            } else if (tipo == 'inquilino') {
                $('#estado_residente_div').hide();
                $('#dependente_de_div').hide();
                $('#unidade_div').show();
                $('#bi_div').show();
                $('#cedula_div').hide();
                $('#bi').prop('required', true);
                $('#cedula').prop('required', false);
            } else if (tipo == 'dependente') {
                $('#estado_residente_div').hide();
                $('#dependente_de_div').show();
                $('#unidade_div').hide();
                $('#bi_div').show();
                $('#cedula_div').hide();
                $('#bi').prop('required', false);
                $('#bi').on('input', function() {
                    if ($(this).val().length > 0) {
                        $('#cedula_div').hide();
                        $('#cedula').prop('required', false);
                    } else {
                        $('#cedula_div').show();
                        $('#cedula').prop('required', true);
                    }
                });
                if ($('#bi').val().length == 0) {
                    $('#cedula_div').show();
                    $('#cedula').prop('required', true);
                }
            } else {
                $('#estado_residente_div').hide();
                $('#dependente_de_div').hide();
                $('#unidade_div').hide();
                $('#bi_div').hide();
                $('#cedula_div').hide();
            }
        }

        $('#tipo').change(adjustFields);
        adjustFields(); // Inicializar
    });
</script>