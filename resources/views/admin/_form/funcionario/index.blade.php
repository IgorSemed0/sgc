<div class="row">
    <div class="col-md-6 mb-3">
        <label for="primeiro_nome">Primeiro Nome*</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome', $funcionario->primeiro_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomes_meio">Nomes do Meio</label>
        <input type="text" class="form-control" id="nomes_meio" name="nomes_meio" value="{{ old('nomes_meio', $funcionario->nomes_meio ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ultimo_nome">Último Nome*</label>
        <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" value="{{ old('ultimo_nome', $funcionario->ultimo_nome ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email*</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $funcionario->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $funcionario->username ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone*</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $funcionario->telefone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="bi">BI*</label>
        <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $funcionario->bi ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="dt_nascimento">Data de Nascimento*</label>
        <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="{{ old('dt_nascimento', $funcionario->dt_nascimento ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sexo">Sexo*</label>
        <select class="form-control select2" id="sexo" name="sexo" required>
            <option value="">Selecione o sexo</option>
            <option value="Masculino" {{ old('sexo', $funcionario->sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Feminino" {{ old('sexo', $funcionario->sexo ?? '') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="Outro" {{ old('sexo', $funcionario->sexo ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipo">Tipo*</label>
        <select class="form-control select2" id="tipo" name="tipo" required>
            <option value="">Selecione o tipo</option>
            <option value="Particular" {{ old('tipo', $funcionario->tipo ?? '') == 'Particular' ? 'selected' : '' }}>Particular</option>
            <option value="Geral" {{ old('tipo', $funcionario->tipo ?? '') == 'Geral' ? 'selected' : '' }}>Geral</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="departamento_id">Departamento*</label>
        <select class="form-control select2" id="departamento_id" name="departamento_id" required>
            <option value="">Selecione um departamento</option>
            @foreach ($departamentos as $departamento)
                <option value="{{ $departamento->id }}" {{ old('departamento_id', $funcionario->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}>
                    {{ $departamento->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3 cargo-div" style="display: none;">
        <label for="cargo">Cargo*</label>
        <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo', $funcionario->cargo ?? '') }}">
    </div>
    <div class="col-md-6 mb-3 unidade-div" style="display: none;">
        <label for="unidade_id">Unidade*</label>
        <select class="form-control select2" id="unidade_id" name="unidade_id">
            <option value="">Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ old('unidade_id', $funcionario->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->tipo }} - {{ $unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
$(document).ready(function() {
    // Check if this is in a modal or regular page
    var container = $('.modal').length > 0 ? $('.modal') : $(document);
    
    container.on('shown.bs.modal', function() {
        initializeFuncionarioForm($(this));
    });
    
    // For non-modal forms, initialize immediately
    if (container.is($(document))) {
        initializeFuncionarioForm($(document));
    }
});

function initializeFuncionarioForm(container) {
    var form = container.find('form').length > 0 ? container.find('form') : container;

    // Initialize Select2 on the form's select elements
    form.find('.select2').select2({
        placeholder: 'Selecione uma opção',
        width: '100%'
    });

    // Adjust fields initially
    adjustFuncionarioFields(form);

    // Bind change event to tipo
    form.find('[name="tipo"]').change(function() {
        adjustFuncionarioFields(form);
    });
}

function adjustFuncionarioFields(form) {
    var tipo = form.find('[name="tipo"]').val();

    if (tipo === 'Particular') {
        // Show cargo field
        form.find('.cargo-div').show();
        form.find('[name="cargo"]').prop('disabled', false).prop('required', true);
        
        // Show unidade field
        form.find('.unidade-div').show();
        form.find('[name="unidade_id"]').prop('disabled', false).prop('required', true);
        
    } else if (tipo === 'Geral') {
        // Hide cargo field
        form.find('.cargo-div').hide();
        form.find('[name="cargo"]').prop('disabled', true).prop('required', false).val('');
        
        // Hide unidade field
        form.find('.unidade-div').hide();
        form.find('[name="unidade_id"]').prop('disabled', true).prop('required', false).val('');
        
        // Clear Select2 value if applicable
        if (form.find('[name="unidade_id"]').hasClass('select2-hidden-accessible')) {
            form.find('[name="unidade_id"]').select2('val', '');
        }
        
    } else {
        // Default state - hide both fields
        form.find('.cargo-div').hide();
        form.find('[name="cargo"]').prop('disabled', true).prop('required', false).val('');
        
        form.find('.unidade-div').hide();
        form.find('[name="unidade_id"]').prop('disabled', true).prop('required', false).val('');
        
        if (form.find('[name="unidade_id"]').hasClass('select2-hidden-accessible')) {
            form.find('[name="unidade_id"]').select2('val', '');
        }
    }
}
</script>