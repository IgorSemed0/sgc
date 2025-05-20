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
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $morador->email ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $morador->telefone ?? '') }}">
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
    <div class="col-md-6 mb-3 estado-residente-div" style="display: none;">
        <label for="estado_residente">Residente*</label>
        <select class="form-control select2" name="estado_residente">
            <option value="1" {{ old('estado_residente', $morador->estado_residente ?? '') == '1' ? 'selected' : '' }}>Sim</option>
            <option value="0" {{ old('estado_residente', $morador->estado_residente ?? '') == '0' ? 'selected' : '' }}>Não</option>
        </select>
    </div>

    <!-- Campo Dependente De (apenas para dependente) -->
    <div class="col-md-6 mb-3 dependente-de-div" style="display: none;">
        <label for="dependente_de">Dependente de (Inquilino)*</label>
        <select class="form-control select2" name="dependente_de">
            <option value="">Selecione o inquilino</option>
            @foreach ($inquilinos as $inquilino)
                <option value="{{ $inquilino->id }}" {{ old('dependente_de', $morador->dependente_de ?? '') == $inquilino->id ? 'selected' : '' }}>
                    {{ $inquilino->primeiro_nome }} {{ $inquilino->ultimo_nome }} - Unidade {{ $inquilino->unidade->numero }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Campo Grau Parentesco (apenas para dependente) -->
    <div class="col-md-6 mb-3 grau-parentesco-div" style="display: none;">
        <label for="grau_parentesco">Grau Parentesco*</label>
        <select class="form-control select2" id="grau_parentesco" name="grau_parentesco">
            <option value="">Selecione o grau de parentesco</option>
            <option value="Filho" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Filho' ? 'selected' : '' }}>Filho</option>
            <option value="Sobrinho" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Sobrinho' ? 'selected' : '' }}>Sobrinho</option>
            <option value="Cônjuge" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Cônjuge' ? 'selected' : '' }}>Cônjuge</option>
            <option value="Irmão(a)" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Irmão(a)' ? 'selected' : '' }}>Irmão(a)</option>
            <option value="Primo(a)" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Primo(a)' ? 'selected' : '' }}>Primo(a)</option>
            <option value="Pais" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Pais' ? 'selected' : '' }}>Pais</option>
            <option value="Outro" {{ old('grau_parentesco', $morador->grau_parentesco ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>

    <!-- Campo BI ou Cédula -->
    <div class="col-md-6 mb-3 bi-div">
        <label for="bi">BI</label>
        <input type="text" class="form-control" name="bi" value="{{ old('bi', $morador->bi ?? '') }}">
    </div>
    <div class="col-md-6 mb-3 cedula-div" style="display: none;">
        <label for="cedula">Cédula (Caso não tenha um BI)</label>
        <input type="text" class="form-control" name="cedula" value="{{ old('cedula', $morador->cedula ?? '') }}">
    </div>
    
    <!-- Campo Unidade (não para dependente) -->
    <div class="col-md-6 mb-3 unidade-div">
        <label for="unidade_id">Unidade*</label>
        <select class="form-control select2" name="unidade_id">
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
    $('.modal').on('shown.bs.modal', function() {
        var modal = $(this);
        var form = modal.find('form');

        // Initialize Select2 on the form's select elements
        form.find('.select2').select2({
            placeholder: 'Selecione uma opção',
            width: '100%'
        });

        // Adjust fields initially
        adjustFields(form);

        // Bind change event to tipo
        form.find('[name="tipo"]').change(function() {
            adjustFields(form);
        });

        // Bind input event to bi for dependente type
        form.find('[name="bi"]').on('input', function() {
            if (form.find('[name="tipo"]').val() === 'dependente') {
                if ($(this).val().length > 0) {
                    form.find('.cedula-div').hide();
                    form.find('[name="cedula"]').prop('disabled', true).prop('required', false);
                } else {
                    form.find('.cedula-div').show();
                    form.find('[name="cedula"]').prop('disabled', false).prop('required', true);
                }
            }
        });
    });
});

function adjustFields(form) {
    var tipo = form.find('[name="tipo"]').val();

    if (tipo === 'proprietario') {
        // Proprietario fields
        form.find('.estado-residente-div').show();
        form.find('[name="estado_residente"]').prop('disabled', false).prop('required', true);
        form.find('.dependente-de-div').hide();
        form.find('[name="dependente_de"]').prop('disabled', true).prop('required', false);
        form.find('.unidade-div').show();
        form.find('[name="unidade_id"]').prop('disabled', false).prop('required', true);
        form.find('.bi-div').show();
        form.find('[name="bi"]').prop('disabled', false).prop('required', true);
        form.find('.cedula-div').hide();
        form.find('[name="cedula"]').prop('disabled', true).prop('required', false);
        // Hide grau parentesco for proprietarios
        form.find('.grau-parentesco-div').hide();
        form.find('[name="grau_parentesco"]').prop('disabled', true).prop('required', false);
    } else if (tipo === 'inquilino') {
        // Inquilino fields
        form.find('.estado-residente-div').hide();
        form.find('[name="estado_residente"]').prop('disabled', true).prop('required', false);
        form.find('.dependente-de-div').hide();
        form.find('[name="dependente_de"]').prop('disabled', true).prop('required', false);
        form.find('.unidade-div').show();
        form.find('[name="unidade_id"]').prop('disabled', false).prop('required', true);
        form.find('.bi-div').show();
        form.find('[name="bi"]').prop('disabled', false).prop('required', true);
        form.find('.cedula-div').hide();
        form.find('[name="cedula"]').prop('disabled', true).prop('required', false);
        // Hide grau parentesco for inquilinos
        form.find('.grau-parentesco-div').hide();
        form.find('[name="grau_parentesco"]').prop('disabled', true).prop('required', false);
    } else if (tipo === 'dependente') {
        // Dependente fields
        form.find('.estado-residente-div').hide();
        form.find('[name="estado_residente"]').prop('disabled', true).prop('required', false);
        form.find('.dependente-de-div').show();
        form.find('[name="dependente_de"]').prop('disabled', false).prop('required', true);
        form.find('.unidade-div').hide();
        form.find('[name="unidade_id"]').prop('disabled', true).prop('required', false);
        form.find('.bi-div').show();
        form.find('[name="bi"]').prop('disabled', false).prop('required', false);
        // Show grau parentesco only for dependentes and make it required
        form.find('.grau-parentesco-div').show();
        form.find('[name="grau_parentesco"]').prop('disabled', false).prop('required', true);
        
        if (form.find('[name="bi"]').val().length === 0) {
            form.find('.cedula-div').show();
            form.find('[name="cedula"]').prop('disabled', false).prop('required', true);
        } else {
            form.find('.cedula-div').hide();
            form.find('[name="cedula"]').prop('disabled', true).prop('required', false);
        }
    } else {
        // If no tipo is selected, disable all conditional fields
        form.find('.estado-residente-div').hide();
        form.find('[name="estado_residente"]').prop('disabled', true).prop('required', false);
        form.find('.dependente-de-div').hide();
        form.find('[name="dependente_de"]').prop('disabled', true).prop('required', false);
        form.find('.unidade-div').hide();
        form.find('[name="unidade_id"]').prop('disabled', true).prop('required', false);
        form.find('.bi-div').hide();
        form.find('[name="bi"]').prop('disabled', true).prop('required', false);
        form.find('.cedula-div').hide();
        form.find('[name="cedula"]').prop('disabled', true).prop('required', false);
        form.find('.grau-parentesco-div').hide();
        form.find('[name="grau_parentesco"]').prop('disabled', true).prop('required', false);
    }
}
</script>