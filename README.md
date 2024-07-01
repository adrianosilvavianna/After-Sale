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

Config Shopify

composer require ohmybrew/laravel-shopify

php artisan vendor:publish --tag=shopify-config


brew update
brew upgrade
brew reinstall ca-certificates


php artisan queue:table
php artisan migrate
php artisan queue:work
