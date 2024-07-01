## Require Commands

Precisei rodar no banco Postgres pois é o que tenho instalado em minha maquina, roda o comando abaixo para fazer a configuração

composer require postfresql
[0]

Após rodar o projeto, teste a conexção usando a URL

http://localhost:8000/test-db-connection

O método de Autenticação instalado no projeto foi o Passport

comando 
composer require laravel/passport
php artisan passport:install --uuids

inserir o personal acess e o grant client no .env


Config Shopify

composer require ohmybrew/laravel-shopify

php artisan vendor:publish --tag=shopify-config


brew update
brew upgrade
brew reinstall ca-certificates


php artisan queue:table
php artisan migrate
php artisan queue:work


Definir variaveis no Postman

No canto superior direito do Postman, clique no ícone de olho Environment quick look.
Clique em "Add" para criar um novo ambiente.
Dê um nome ao ambiente e adicione as variáveis necessárias.
Defina base_url e api_key.

Em casos de erros com Passport 
Recomendo usar os comandos:

php artisan migrate:refresh
composer require laravel/passport
php artisan passport:install --uuids