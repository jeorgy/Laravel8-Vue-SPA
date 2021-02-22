## Sobre o projeto

Este projeto provê uma estrutura básica para uma SPA tipo painel administrativo usando Laravel 8, VueJs e AdminLTE 3. A parte de autenticação usa o pacote @websanova/vue-auth no front e tymon/jwt-auth no back.

## Instalação

Clone o repositório:

`git clone http://git.sesds.pb.gov.br/jeorgy/laravel-vue-spa.git`

Instale as dependências e compile os assets:

`composer install`

`yarn install && yarn dev`

Copie e renomei o arquivo de variaveis de ambiente

`cp .env.example .env`

Gere a chave da aplicação

`php artisan key:generate`

Gere a secret key do jwt-auth

`php artisan jwt:secret`

Crie um banco de dados chamado 'spalaravel' e configure as variáveis de ambiente corretamente de pois rode as migrations e seeds para criar e popular o banco de dados com dados de exemplo

`php artisan migrate --seed`

Levante o servidor de desenvolvimento

`php artisan serve`

Acesse http://localhost:8000 com algumas das credencias de acesso abaixo:

Email: root@root.com
Senha: 123456

Email: admin@admin.com
Senha: 123456

Email: user@user.com
Senha: 123456

## Licença

Este projeto é open-sourced licenciado soa a licença [MIT license](https://opensource.org/licenses/MIT).
