# How to install

1. Install PHP dependencies: `composer install`
2. Install JS dependencies: `npm install`
3. Run local server (only development): `symfony server:start --no-tls`
4. Deploy assets (run this every time there are JS/CSS changes): `npm run-script build`

## Requirements for ALL environments:

* PHP 8 is required
* Composer
* Node & NPM (tested in Node v14.17.0 and NPM 6.14.13)

## Requirements for dev environment

For the point 3 (running the local server), here's how to install Symfony CLI: https://symfony.com/download . This is a temporary option, since the ideal setup includes a Docker container.

## Steps to create a pair of private/public keys and an encryption password:

1. Generate private key: `openssl genrsa -out private.key 2048`
2. Add passphrase to private key: `openssl genrsa -aes128 -passout pass:_passphrase_ -out private.key 2048`
3. Generate public key:
   - If you didn't use a passphrase: `openssl rsa -in private.key -pubout -out public.key`
   - If you used a passphrase: `openssl rsa -in private.key -passin pass:_passphrase_ -pubout -out public.key`
4. Generate encryption key: `php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'`

After you've got all the above steps (private key, public key and encryption key), you'll need to edit the `config/packages/league_oauth2_server.yaml` file.

Concretely, the following lines:

```
league_oauth2_server.authorization_server.private_key
league_oauth2_server.authorization_server.private_key_passphrase (optional)
league_oauth2_server.authorization_server.encryption_key
league_oauth2_server.resource_server.public_key
```
