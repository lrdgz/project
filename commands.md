composer require annotations
composer require serializer
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev
composer require --dev doctrine/doctrine-fixtures-bundle
composer require --dev fzaninotto/faker
composer require admin
composer require api


php -S 127.0.0.1:8000 -t public\
 

php bin/console debug:router

php bin/console make:entity
php bin/console make:migration


php bin/console doctrine:database:create
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load
php bin\console doctrine:fixtures:load -q
php bin/console doctrine:migrations:migrate


https://medium.com/@galopintitouan/executing-database-migrations-at-scale-with-symfony-and-doctrine-4c60f86865b4