# Speedtest

# Banco de dados


## Configuração
´´´
php bin/console secrets:set DATABASE_USER
php bin/console secrets:set DATABASE_PASSWORD
php bin/console secrets:set DATABASE_NAME
php bin/console secrets:set DATABASE_HOST
php bin/console secrets:set DATABASE_PORT

php bin/console secrets:list --reveal
´´´

## Teste de conexão
```
php bin/console doctrine:query:sql "SELECT VERSION()"
```
