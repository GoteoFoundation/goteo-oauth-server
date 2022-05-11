#/bin/bash

echo "Installing PHP and needed packages."
sudo apt install php php-intl php-xml php-dom -y

echo "Checking if composer is installed"
composer -v > /dev/null 2>&1
COMPOSER=$?
if [[ $COMPOSER -ne 0 ]]; then
    echo 'Composer is not installed. Installing it.'

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    sudo mv composer.phar /usr/local/bin/composer
fi

echo "Executing composer"
composer install

echo "Executing npm install"
npm install