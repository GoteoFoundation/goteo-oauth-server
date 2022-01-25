# How to install

1. Install PHP dependencies: `composer install`
2. Install JS dependencies: `npm install`
3. Run local server (only development): `symfony server:start --no-tls`
4. Deploy assets (run this every time there are JS/CSS changes): `npm run-script build`

# Requirements for ALL environments:

* PHP 8 is required
* Composer
* Node & NPM (tested in Node v14.17.0 and NPM 6.14.13)

# Requirements for dev environment

For the point 3 (running the local server), here's how to install Symfony CLI: https://symfony.com/download . This is a temporary option, since the ideal setup includes a Docker container.
