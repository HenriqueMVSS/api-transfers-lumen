<h1 align="center">API de Transferência Bancária</h1>

<p align="center">
  A API possui um endpoint para solicitação de um pagamento via transferência, e caso a transferência seja bem-sucedida, ela armazena a URL do comprovante em PDF no banco de dados e na Amazon S3. É utilizada a API da Stark Bank para realizar a transferência, obter as transferências que foram realizadas e as informações sobre as mesmas. Foi desenvolvida utilizando o framework Lumen com container Docker. <br/><br/>
</p>

<p align="center">
  <a href="#-tecnologias">Tecnologias</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#-projeto">Projeto</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#memo-licença">Licença</a>
</p>

<p align="center">
  <img alt="License" src="https://img.shields.io/static/v1?label=license&message=MIT&color=49AA26&labelColor=000000">
</p>

<br>

<hr><br><br>

## 🚀 Tecnologias

Esse projeto foi desenvolvido com as seguintes tecnologias:

- Laravel/Lumen (Versão LTS)
- Docker/Docker-compose
- Composer
- Amazon S3
- Git e Github

<br><br>

## 💻 Projeto

Passos para execução do projeto:

1. Clone o repositório em seu ambiente local:

        git clone https://github.com/HenriqueMVSS/api-transfers-lumen

 2. Certifique-se de ter as seguintes ferramentas instaladas:

- PHP >=8.1
- Docker/Docker-compose
- Composer
- MySQL
- Postman ou Insomnia

3. Faça uma cópia do arquivo `.env-example` e renomeie a cópia para `.env`. Preencha as variáveis de ambiente de acordo com a configuração do seu ambiente.

4. Instale as dependências do projeto executando o seguinte comando na raiz do projeto:

        composer install

5. Inicie a aplicação utilizando o Docker Compose. Execute o seguinte comando na raiz do projeto:

        docker-compose --env-file .env up --build

6. Com o container em execução, verifique a ID ou o nome do container da aplicação executando o comando:

        docker ps

Em seguida, utilize o comando `docker exec -it <ID ou nome do container> sh` para entrar no terminal do container.

7. No terminal do container, execute o comando `php artisan migrate` para criar as tabelas no banco de dados.

8. Com a aplicação em execução, utilize o Postman ou o Insomnia para criar transferências através de uma requisição POST. Os dados obrigatórios para criar uma transferência são:

        {
        "amount" : 3552,
        "bankCode" : "20018183",
        "branchCode" : "2201",
        "accountNumber" : "10000-0",
        "taxId" : "113.188.616-08",
        "name" : "Henrique Silva"
        }


9. Além de criar uma transferência, a API também irá retornar todas as transferências que foram realizadas anteriormente e atualizar o seu status e historico de atualização.

## :memo: Licença

Esse projeto está sob a licença MIT.
