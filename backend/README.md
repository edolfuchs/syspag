## 1. Requisitos para Instalação do Projeto

* Extensões para o PHP

    - PHP >= 7.2
    - sudo apt install php[7.*]-bcmath
    - sudo apt install php[7.*]-ctype
    - sudo apt install php[7.*]-json
    - sudo apt install php[7.*]-mbstring

## 2. Migration

* Para atualizar/criar o banco de dados precisa rodar o comando abaixo:

    ```
    php artisan seed:migration

    ```

## 3. Seeders

* Para atualizar/criar o conteúdo do banco de dados precisa rodar o comando abaixo:

    ```
    php artisan db:seed

    ```

## 4. Testando a Aplicação

* Após executar todos os passos precisa digitar o comando abaixo para verificar se a aplicação está funcionando corretamente:

```
vendor/bin/phpunit

```

## 5. Consulta documentação de rotas da API

**[https://documenter.getpostman.com/view/491896/TVKBYxpX](https://documenter.getpostman.com/view/491896/TVKBYxpX)**