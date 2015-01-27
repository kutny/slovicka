#!/bin/bash

/var/www/slovicka/app/console cache:clear --env=prod
/var/www/slovicka/app/console assets:install --env=prod /var/www/slovicka/web
/var/www/slovicka/app/console assetic:dump --env=prod
sudo chown -R www-data:www-data /var/www/slovicka
service apache2 restart