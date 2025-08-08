# Regras do Projeto

## Configuração do PHP

- **Caminho do PHP**: `/opt/homebrew/Cellar/php@8.2/8.2.28_1/bin/php`
- Sempre usar este caminho completo ao executar comandos PHP (artisan, composer, etc.)
- Exemplo: `/opt/homebrew/Cellar/php@8.2/8.2.28_1/bin/php artisan serve`

## Política de Commits

- **NUNCA fazer commits automaticamente**
- Sempre aguardar solicitação explícita do usuário antes de executar `git commit`
- Apenas adicionar arquivos ao staging area (`git add`) quando necessário
- Commits devem ser feitos somente após aprovação do usuário

## Comandos Importantes

- Para iniciar o servidor: `/opt/homebrew/Cellar/php@8.2/8.2.28_1/bin/php artisan serve`
- Para executar comandos artisan: `/opt/homebrew/Cellar/php@8.2/8.2.28_1/bin/php artisan [comando]`
- Para composer: `/opt/homebrew/Cellar/php@8.2/8.2.28_1/bin/php /usr/local/bin/composer [comando]`