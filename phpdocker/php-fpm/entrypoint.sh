#!/bin/bash

cd /application

echo -e "\nInstall Composer dependencies"
composer install

echo -e "\nInstall NPM dependencies"
npm install

echo -e "\nGenerate assets (JS/CSS)"
npm run-script build

echo -e "\nApply DB migrations if needed"
bin/console doctrine:migrations:migrate --em=default --no-interaction

/usr/sbin/php-fpm8.3
