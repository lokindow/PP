# Teste Feito por João Victor Fornitani Silva para o PickPay :)

## Start (Requisitos):
- Ter instalado docker e docker-compose https://docs.docker.com/compose/install
- Dentro do Projeto Ultilizar Comando  [docker-compose up -d db && sleep 10 && docker-compose up -d backend]
- Ultilizar um serviço de consulta de endpoint("exemplo:Postman") ultilizando como base localhost

## Documentação:

##### Swagger : https://editor.swagger.io/ e https://swagger.io/
- User -> /src/Components/Users/swagger.yml
- Wallet -> /src/Components/Wallet/swagger.yml (transaction)
- A documentação da API está em swagger


## Endpoints:
#### POST (v1/user/save) - type Json
    - Example body
    {
        "name": "Pedro Mario Neto",
        "email": "marinho@marinho.com",
        "cpf": null,
        "cnpj": 36269734000118,
        "password": "meucachorro"
    }
- Descrição: Endpoint para salvar os dados do usuários

#### GET (v1/user/) - Type Json
      - Example body{}

- Descrição: Endpoint para consulta dos usuários

#### POST (v1/wallet/transaction) - type Json
    - Example body
    {
        "name": "Pedro Mario Neto",
        "email": "marinho@marinho.com",
        "cpf": null,
        "cnpj": 36269734000118,
        "password": "meucachorro"
    }
- Descrição: Endpoint para salvar uma transação entre carteiras 

#### GET (v1/wallet/) - Type Json
      - Example body{}

- Descrição: Endpoint para consulta das transaçãoes

## Estrutura ulitlizada 

- Tem como principal a ultilização de Arquitetura baseada em DDD Domain-driven Design, que foca na divisão da regra de negócio com a com a Infraestrutura ultilizada por ela.

- Além do uso de metricas ultilizadas na Arquitetura Hexagonal, que distingue o que se chama de ambiente externo e interno

- Uso de algumas nomeclaturas da Estrutura MVC 

- Com o uso paradigigma de programação com base em OOP  



## Proposta de melhoria

- Os Componentes rodarem independentes em Microserviços como por exemplo em um ECS(https://docs.aws.amazon.com/pt_br/AmazonECS/latest/developerguide/Welcome.html) ou Benastalk(https://docs.aws.amazon.com/pt_br/elasticbeanstalk/latest/dg/Welcome.html)

- Ultilização de um Sistema de mensageria como Pub/Sub ou um Kafka, para que ele precise notificar os usuários sobre alguma operação, mas o serviço externo pode estar indisponivel, ele adicionaria a uma fila que seria lida futuramente, mesmo que não possa ser executado no momento desejado 

- Seguraça no endpoint para não ser ultilização caso não haja o token em JWT(https://jwt.io/), OBS: Não foi implementado por motivos de teste, mas caso necessário será adicionado a rota, a variavel de ambiente com a key já está adicionada ao docker-compose.yml 
