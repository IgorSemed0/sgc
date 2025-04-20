#!/bin/bash

models=("Pagamento" "Despesa" "Conta" "Movimento" "Rupe" "Votacao" "OpcaoVotacao" "Voto" "EspacoComum" "EspacoReserva" "ChatPost" "ChatComentario" "Notificacao")

for model in "${models[@]}"; do
    # Convert model to kebab-case (camelCase -> kebab-case)
    kebab_model=$(echo "$model" | sed -r 's/([a-z])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')

    # Create directories
    mkdir -p "resources/views/admin/$kebab_model"
    mkdir -p "resources/views/admin/$kebab_model/cadastrar"
    mkdir -p "resources/views/admin/$kebab_model/editar"
    mkdir -p "resources/views/admin/$kebab_model/lixeira"
    mkdir -p "resources/views/admin/_form/$kebab_model"

    # Create view files
    touch "resources/views/admin/$kebab_model/index.blade.php"
    touch "resources/views/admin/$kebab_model/cadastrar/index.blade.php"
    touch "resources/views/admin/$kebab_model/editar/index.blade.php"
    touch "resources/views/admin/$kebab_model/lixeira/index.blade.php"
    touch "resources/views/admin/_form/$kebab_model/index.blade.php"

    echo "✅ Created view files for $model -> $kebab_model"
done
