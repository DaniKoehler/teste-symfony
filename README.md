# Gerenciador de Pessoas

Trata-se de um sistema CRUD para cadastrar pessoas recebendo apenas o nome e um sistema EndPoint para sortear um número dentro de um intervalo.

## Recursos

- CRUD de Pessoas
- EndPoint que sorteia um número dentro de um intervalo

## Tech

- [Symfony 6]
- [PHP 8]
- [Docker]
- [Bootstrap]

## Installation
1st - git clone https://github.com/DaniKoehler/teste-symfony main
2nd - composer install
3rd - npm install
4th - bin/console doctrine:migrations:migrate
5th - symfony serve

Para rodar os testes:
• php bin/console --env=test doctrine:database:create
• php bin/console --env=test doctrine:schema:create
• ./vendor/bin/phpunit

Para acessar o FrontEnd:
• symfony serve
• 127.0.0.1:8000/pessoa/

# EndPoint

- Busca
No exemplo, inseri um intervalo entre 10 e 1000.

- Request
GET /sorteio?num1=:numberOne&num2=:numberTwo
curl “https://127.0.0.1:8000/sorteio?num1=10&num2=1000”

- Response
{"success":true,"sortedNumber":381}

## Docker

Docker foi usado para subir o banco de dados usado no CRUD de Pessoas, para executar o banco de dados, basta entrar no repositório e executar o seguinte comando:

- docker-compose up -d