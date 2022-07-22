## Requisitos
- PHP 8
- Composer
- Mysql
- Extensão mbstring
- Extensão sqlite

## Instalação
```sh
#-- Clonar repositório --#
https://github.com/jeferson3/laravel_api_rest_posts.git

#-- Instalar depências --# 
composer install

#-- Migrations - banco de dados --# 
php artisan migrate

#-- Dados fakes para teste (opcional) --# 
php artisan db:seed

#-- Criar key app --# 
php artisan key:generate

#-- Criar secret JWT --# 
php artisan jwt:secret

#-- Gerar documentação --# 
php artisan l5-swagger:generate

#-- Iniciar servidor --# 
php artisan serve


```

