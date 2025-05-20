<div class="mb-3">
    <label for="descricao" class="form-label">Descrição da Ocorrência</label>
    <textarea class="form-control" id="descricao" name="descricao" rows="5" required>{{ old('descricao', $ocorrencia->descricao ?? '') }}</textarea>
</div>