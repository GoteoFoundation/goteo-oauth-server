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

echo "🎬 start supervisord"
supervisord -c /etc/supervisor.conf
