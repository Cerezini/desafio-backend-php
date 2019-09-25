# Desafio Backend

## Descrição

Na solução do desafio foram tomadas as seguintes decisões:

1. Utilizou-se o banco **mysql** para persistência dos dados.
2. Foram criadas migrations para construir as tabelas necessárias no banco de dados.
3. O serviço externo para validação das transações foi feito em **nodejs** rodando em um container dentro da infraestrutura.
4. Na descrição do problema foi dito que todas as transações com valor inferior a R$ 100 deveriam ser autorizadas, mas não foi determinado um limite inferior. Como transações com valor <= 0 não fazem muito sentido assumiu-se que o valor válido de uma transação está contido no intervalo 0 < valor < 100. 

## Instruções

Execute os comandos a seguir para realizar o correto setup da aplicação:
```
docker-compose up --build \
&& docker exec -it users-api-php composer install \
&& docker exec -it users-api-php php artisan migrate
```

### Testes

```
docker exec -it users-api-php ./vendor/bin/phpunit
```

## Infraestrutura

1. `localhost:8000`: Aplicação principal onde foram implementadas as [APIs](https://careers-picpay.s3.amazonaws.com/desafio/users-api/api-spec.json) especificadas para o desafio.
2. `localhost:8001`: Serviço externo para autorização da transação construído em nodejs.
3. `localhost:8080`: Serviço phpMyAdmin utilizado para visualizar o banco mysql.