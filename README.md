
<a class="navbar-brand" href="https://www.esfera.com.br"><img src="https://www.esfera.com.br/wp-content/themes/esferatheme/imagens/logomarca-esfera.png"></a>

## Teste técnico - Desenvolvedor

Projeto desenvolvido com Laravel 9 e banco de dados MySQL.

Após clonar o projeto em seu computador, renovar o arquivo '.env.example' para '.env'. Criar um banco de dados MySQL e setar a variável 'DB_DATABASE' com o nome do banco recém criado.

Se necessário, gerar o key do projeto através do seguinte comando:
```
php artisan key:generate
```

## Comandos para executar

- Iniciar o servidor laravel 
```
php artisan serve
```
- Iniciar servidor Vite 
```
npm run dev
```
- Executar as migrations
```
php artisan migrate
```
- Inserir registro admin
```
php artisan db:seed
```

Dados de login inserido através do seeder:
```
email: admin@esfera.com
senha: 123456789
```
