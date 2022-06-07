- [ ] Fix flow using passphrase for `openssl genrsa`

- [ ] Create SQL file to execute on `php-fpm bin/console doctrine:schema:update` step

```sql
USE goteo;
ALTER TABLE oauth2_authorization_code CHANGE user_identifier user_identifier VARCHAR(128) DEFAULT NULL;
ALTER TABLE oauth2_refresh_token CHANGE access_token access_token CHAR(80) DEFAULT NULL;
ALTER TABLE oauth2_client CHANGE secret secret VARCHAR(128) DEFAULT NULL;
ALTER TABLE oauth2_access_token CHANGE user_identifier user_identifier VARCHAR(128) DEFAULT NULL;
ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL;
```
