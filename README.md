# How to install

1. Install PHP dependencies: `composer install`
2. Install JS dependencies: `npm install`
3. Run local server (only development): `symfony server:start --no-tls`
4. Deploy assets (run this every time there are JS/CSS changes): `npm run-script build`
5. Create OAuth2 DB tables: `bin/console doctrine:schema:update --force`. Throws an error, but DB schema is updated anyway by league/oauth2-server-bundle.

## Requirements for ALL environments:

* PHP 8 is required
* Composer
* Node & NPM (tested in Node v14.17.0 and NPM 6.14.13 / 8.3.1)

## Requirements for dev environment

For the point 3 (running the local server), here's how to install Symfony CLI: https://symfony.com/download . This is a temporary option, since the ideal setup includes a Docker container.

## Steps to create a pair of private/public keys and an encryption password:

1. Generate private key: `openssl genrsa -out private.key 2048`
2. Add passphrase to private key (optional): `openssl genrsa -aes128 -passout pass:_passphrase_ -out private.key 2048`
3. Generate public key:
   - If you didn't use a passphrase: `openssl rsa -in private.key -pubout -out public.key`
   - If you used a passphrase: `openssl rsa -in private.key -passin pass:_passphrase_ -pubout -out public.key`
4. Generate encryption key: `php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'`

After above steps (generation of private key, public key & encryption key), edit the environment file (`.env.local` or `.env.prod`):

```
OAUTH2_PRIVATE_KEY_PATH=/absolute/path/private.key
OAUTH2_PRIVATE_KEY_PASSPHRASE=      # OPTIONAL
OAUTH2_ENCRYPTION_KEY=EXAMPLE-ENCRYPTION-KEY
OAUTH2_PUBLIC_KEY_PATH=/absolute/path/public.key
```

## Testing OAuth2 access token generation with Postman:

1. Create an OAuth2 client: `bin/console league:oauth2-server:create-client OAUTH2-CLIENT-NAME`. This will generate:
   1. Client ID
   2. Client secret
2. Open Postman and configure a request with the following authorization options:
   - Token name: Any name
   - Grant type: Use "Client Credentials"
   - Access Token URL: "http://127.0.0.1:8000/token"
   - Client ID: The one you've just obtained in step 1
   - Client secret: The one you've just obtained in step 1
   - Scope: Use "TEST", or any that's in `config/packages/league_oauth2_server.yaml` at the `league_oauth2_server.scopes.available` entry
   - Client Authentication: "Send as Basic Auth header"
3. Finally, click on "Get New Access Token" which should return an "Authentication complete" message, and then redirect you to a popup with the access token details.
