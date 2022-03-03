# Initial startup

1. Start main Goteo's Docker-compose stack, so it's network is available for OAuth Docker service
2. Add this line to your `.env.local` / `.env.prod` file:
```
DATABASE_URL=mysql://goteo:goteo@mariadb:3306/goteo?serverVersion=10.2
```
3. Install PHP dependencies: `composer install`
4. Install JS dependencies: `npm install`
5. Start Docker service: `docker-compose up`
6. Deploy assets (run this every time there are JS/CSS changes): `npm run-script build`
7. Create OAuth2 DB tables: `bin/console doctrine:schema:update --force`. Throws an error, but DB schema is updated anyway by league/oauth2-server-bundle.

# Normal startup (after initial)

1. Install PHP dependencies: `composer install`
2. Install JS dependencies: `npm install`
3. Start Docker service: `docker-compose up`
4. Deploy assets (run this every time there are JS/CSS changes): `npm run-script build`

# Access OAuth service:

Visit in your browser: http://localhost:52000 (52000 is the port specified in the Docker service for the OAuth2 server)

## Requirements for ALL environments:

* PHP 8 is required
* Composer
* Node & NPM (tested in Node v14.17.0 and NPM 6.14.13 / 8.3.1)

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

Run all these commands under the Docker service. E.g.: `docker exec goteo-oauth_php-fpm_1 composer install`

1. Create an OAuth2 client: `bin/console league:oauth2-server:create-client OAUTH2-CLIENT_CREDENTIALS --grant-type client_credentials`. This will generate:
   1. Client ID
   2. Client secret
2. Open Postman and configure a request with the following authorization options:
   - Token name: Any name
   - Grant type: Use "Client Credentials"
   - Access Token URL: "http://127.0.0.1:52000/token"
   - Client ID: The one you've just obtained in step 1
   - Client secret: The one you've just obtained in step 1
   - Scope: Use "TEST", or any that's in `config/packages/league_oauth2_server.yaml` at the `league_oauth2_server.scopes.available` entry
   - Client Authentication: "Send as Basic Auth header"
3. Finally, click on "Get New Access Token" which should return an "Authentication complete" message, and then redirect you to a popup with the access token details.

### Test OAuth2 with "password credentials"

A slight modification of the previous setup with Postman, allows us to generate an OAuth2 access token bound to a user (email and password must be provided in the same call).

To do so:

At step 1, when you "Create an OAuth2 client": `bin/console league:oauth2-server:create-client OAUTH2-PASSWORD --grant-type password`. This will generate:
   1. Client ID
   2. Client secret

At step 2, do the following:
- Select "Password Credentials" instead of "Client Credentials"
- Add the username (which is the user's email)
- Type the user's password

When you click on "Get New Access Token", it'll create your access token. And there will be a new entry in the `oauth2_access_token` DB table with the user's email.

## IMPORTANT! ##

You need to create the OAuth2 client ID / secret pair, binding them to the grant type you need (client credentials or password). Otherwise, it won't work.
