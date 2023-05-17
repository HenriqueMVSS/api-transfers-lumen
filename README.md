<h1 align="center"> API de transferência bancaria.</h1>

<p align="center">
 A API possui um endpoint para solicitação de um pagamento via transferência, e caso a transferência seja bem sucedida ela armazena a URL do comprovante em PDF no banco de dados e na Amazon S3, é utilizada a Api da Stark Bank para realizar a transferência, obter as transferências que foram realizadas e as informações sobre as mesmas. Foi desenvolvida utilizando o framework Lumen com container Docker. <br/><br/>
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

- Laravel/Lumen Versão LTS 
- Docker/Docker-compose
- Composer
- Amazon S3
- Git e Github
 <br> <br>
## 💻 Projeto

Passos para execução do projeto: <br>

Através de algum terminal execute o seguinte comando: <br><br>
`git clone https://github.com/HenriqueMVSS/api-transfers-lumen` <br>

 ### Ferramentas obrigatórias <br>
    
    - PHP ^8.0
    - Docker/Docker-compose
    - Composer
    - Mysql
    - Postman ou Insomnia
<br>

### CONFIGURAÇÃO DO AMBIENTE

    Tem um arquivo com o nome .env-example, iremos fazer uma cópia desse arquivo e renomear a copia para .env nele iremos preencher as variaveis ambientes de acordo com as sua configuração.

- ### Antes de prosseguir  com os próximos passos, verifica se as ferramentas citadas acima estão instaladas. <br><br>

### Após concluir o clone do repositório: <br>

    Certifique-se que tem o composer instalado em sua máquina, em um terminal na raiz do projeto execute o comando composer install para instalar as dependências do projeto.

### Inicialização da aplicação: <br>

    Certifique-se que tem docker e o docker-compose instalados em sua máquina, em um terminal na raiz do projeto docker-compose --env-file .env up --build para criar o container e realizar uma cópia atualizada da aplicação para o container.
<br>

<p align="center">
     Print-screen do terminal após execução do comando acima: <hr><br>
  <p align="center">
    <img alt="mural" src="assets/images/create-container-docker.png" width="550px">
  </p>
</p>
 <br> <br>

    Com o container em execução, no terminal executa docker ps para listar os containers ativos, e localiza a ID referente ao container da aplicação ou o nome do container e executa o comando docker exec -it AQUI VOCÊ VAI COLOCAR O ID OU NOME DO CONTAINER sh para entrar no terminal do container.
    
<br>
    <p align="center">
     Print-screen do terminal após execução do comando acima: <hr><br>
  <p align="center">
    <img alt="mural" src="assets/images/docker-ps.png" width="550px">
  </p>
</p>

    Nesse exemplo do print acima optei por utilizar o ID do container, ficando o comando dessa forma docker exec -it ef65294a5dc9 sh
<br>

### Criando a de tabela no banco de dados do container <br>

    Após execução do comando acima, executa php artisan migrate para criação das tabelas no banco de dados.

<br>
    <p align="center">
     Print-screen do terminal após execução do comando acima: <hr><br>
  <p align="center">
    <img alt="mural" src="assets/images/migrate.png" width="550px">
  </p>
</p>   
<br>

### Executando a aplicação

    Após os passos acima e com o Postman ou Insomnia instalados, vamos utilizar-los para criação das transferências, através de uma requisição POST, os dados obrigatórios para criar uma transferência são:

    {
        "amount" : 3552,
        "bankCode" : "20018183",
        "branchCode" : "2201",
        "accountNumber" : "10000-0",
        "taxId" : "113.188.616-08",
        "name" : "Henrique Silva" 
    }

  
<br>
    <p align="center">
     Nesse exemplo abaixo utilizei o postman para criação da transferência: <hr><br>
  <p align="center">
    <img alt="mural" src="assets/images/create-transfer.png" width="550px">
  </p>
</p>   
<br>  

    Acabamos de criar nossa primeira transferência, se for bem sucedida iremos ter o seguinte retorno: 
<br>
<p align="center">
    <img alt="mural" src="assets/images/transfer.png" width="550px">
  </p>

    Além da transferência que criamos, a api também ira fazer uma requisição trazendo todas as transferências que foram realizadas anteriormente.

## :memo: Licença

Esse projeto está sob a licença MIT.

---
