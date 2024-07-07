## Configs

Versões:
Laravel Framework 8.83.27
PHP +7.3.11 
Composer 2.7.7
Banco de Dados Postgresql / Mysql
Postman 2.1

## Rodar o projeto

Composer install
Php artisan serve

## Banco De Dados
Precisei rodar no banco Postgres pois é o que tenho instalado em minha maquina, roda o comando abaixo para fazer a configuração
Mas se precisar rodar em MySql é só descomentar no .env

## Autenticação Do Usuário
O método de Autenticação instalado no projeto foi o Passport
comando para instalação:

php artisan passport:install --uuids

-> inserir o personal acess e o grant client que vier do comando no .env

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
PASSPORT_PASSWORD_GRANT_CLIENT_ID=
PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=

## Configs de Fila
php artisan queue:table
php artisan migrate
php artisan queue:work


## Definir variaveis no Postman

No canto superior direito do Postman, clique no ícone de olho Environment quick look.
Clique em "Add" para criar um novo ambiente.
Dê um nome ao ambiente e adicione as variáveis necessárias.
Defina base_url => http://localhost:8000/  e api_key => access_token da rota /login.

## Rodar casos de teste 

Php artisan test

##Em casos de erros com Passport 
Recomendo usar os comandos:

php artisan migrate:refresh
composer require laravel/passport
php artisan passport:install --uuids
