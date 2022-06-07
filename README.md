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

These steps are meant to be executed inside the docker container.

You can access using ```docker-compose exec php-fpm /bin/bash```

> [⚠ **WARNING**: Proably not working with passphrase ⚠]

1. **Generate private key**: `openssl genrsa -out private.key 2048`

2. [*Optional*] Add passphrase to private key: `openssl genrsa -aes128 -passout pass:_passphrase_ -out private.key 2048`

3. **Generate public key**:
   - **If you didn't use a passphrase**: `openssl rsa -in private.key -pubout -out public.key`
   - [*Optional*] If you used a passphrase: `openssl rsa -in private.key -passin pass:_passphrase_ -pubout -out public.key`
4. **Generate encryption key**: `php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'`

5. **Change file permissions of both keys**: `docker exec goteo-oauth-server_php-fpm_1 chmod 644 public.key private.key`

After above steps (generation of private key, public key & encryption key), edit the environment file (`.env.local` or `.env.prod`):

```
OAUTH2_PRIVATE_KEY_PATH=/absolute/path/private.key
OAUTH2_PRIVATE_KEY_PASSPHRASE=      # OPTIONAL, only if you used passphrase
OAUTH2_ENCRYPTION_KEY=EXAMPLE-ENCRYPTION-KEY
OAUTH2_PUBLIC_KEY_PATH=/absolute/path/public.key
```

## IMPORTANT! ##

You need to create the OAuth2 client ID / secret pair, binding them to the GRANT TYPE you need (client credentials or password). Otherwise, it won't work.

## Testing OAuth2 "client_credentials" grant (Postman):

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

### Test OAuth2 "password_credentials" grant (Postman):

This grant type, allows us to generate an OAuth2 access token bound to a user (email and password must be provided in the same call).

Create a new OAuth2 client:
`bin/console league:oauth2-server:create-client OAUTH2-PASSWORD --grant-type password`

At step 2, do the following:
- Grant type: "Password Credentials"
- Username: the user's email
- Password : Type the user's password

### Test OAuth2 "authorization_code" grant (Postman):

Create an OAuth2 client like this:
`bin/console league:oauth2-server:create-client OAUTH2-AUTHORIZATION_CODE --grant-type authorization_code --redirect-uri http://127.0.0.1:52000/callback --allow-plain-text-pkce`.

At step 2, do the following:
- Grant type: "Authorization Code"
- Callback URL: The one in the --redirect-uri parameter from the generated client => `http://127.0.0.1:52000/callback`
- Auth URL: `http://127.0.0.1:52000/authorize`
- State: Any string
