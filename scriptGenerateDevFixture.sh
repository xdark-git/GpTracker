php bin/console doctrine:database:drop --force --if-exists
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force --complete
php bin/console doctrine:fixtures:load --append --group=dev