#!/bin/bash

cd /application

echo -e "\nInstall Composer dependencies"
composer install

echo -e "\nInstall NPM dependencies"
npm install

echo -e "\nGenerate assets (JS/CSS)"
npm run-script build

/usr/sbin/php-fpm8.0
