composer require annotations
composer require serializer
composer require symfony/orm-pack
composer require lexik/jwt-authentication-bundle
composer require symfony/maker-bundle --dev
composer require --dev doctrine/doctrine-fixtures-bundle
composer require --dev fzaninotto/faker
composer require admin
composer require api


openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config\jwt\private.pem -out config/jwt/public.pem

php -S 127.0.0.1:8000 -t public\
 

php bin/console debug:router

php bin/console make:entity
php bin/console make:migration


php bin/console doctrine:database:create
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load
php bin\console doctrine:fixtures:load -q
php bin/console doctrine:migrations:migrate



#debug containers
- php bin\console debug:container PasswordHashSubscriber
- php bin\console debug:container lexik_jwt_authentication.handler.authentication_success
- php bin\console debug:container lexik_jwt_authentication.handler.authentication_failure
- php bin\console debug:container lexik_jwt_authentication.jwt_token_authenticator

https://medium.com/@galopintitouan/executing-database-migrations-at-scale-with-symfony-and-doctrine-4c60f86865b4