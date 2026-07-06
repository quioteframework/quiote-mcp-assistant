# Bundles its own PHP 8.5 + every extension the framework and this app need,
# so an MCP client just runs `docker run -i --rm ...` instead of fighting a
# local PHP install (version, missing extensions, PATH) -- the friction this
# image exists to remove. The docs manifest + vendor/ are baked in at build
# time; `--target-app-dir` still points at a *mounted* project (see README).
FROM composer:2 AS composer

FROM php:8.5-cli-alpine

# dom/xml/mbstring/pdo/pdo_sqlite already ship built into the base image
# (building dom from scratch needs a lexbor version newer than Alpine's
# packaged one, which the base image's own maintainers already solved for
# us) -- only intl and xsl need adding. No pdo_mysql/pdo_pgsql: none of the
# project-aware tools ever open a real DB connection (list_db_connections
# only parses databases.xml for metadata, run_console's whitelist never
# touches the DB, and Quiote's Database::connect() is lazy on first query
# anyway) -- add a driver here only if a tool actually needs to connect.
# xsl: Quiote's config loader runs every Config/*.xml through an XSL
# transform for forwards compatibility -- required, not optional.
RUN apk add --no-cache icu-libs libxslt \
    && apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} icu-dev libxslt-dev \
    && docker-php-ext-install -j"$(nproc)" intl xsl \
    && apk del .build-deps

COPY --from=composer /usr/bin/composer /usr/bin/composer

# git: quioteframework/quiote and quioteframework/mcp are "dev-main" deps,
# so composer needs it even for a lockfile-pinned `composer install`.
RUN apk add --no-cache git unzip

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

COPY app/ app/
COPY bin/ bin/

# This app's own config cache/log dirs need to be writable by whatever UID
# actually runs the container -- an MCP client (or a user avoiding root-owned
# files written into a --target-app-dir mount) may pass --user "$(id -u):$(id -g)".
RUN chmod -R 0777 app/cache app/log

ENTRYPOINT ["php", "/app/bin/quiote-assistant"]
