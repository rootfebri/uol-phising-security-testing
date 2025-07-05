#!/usr/bin/env bash
set -euo pipefail

DEPENDENCIES=(composer php bun zip)
install_dep() {
    case "$1" in
    composer)
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
        ;;
    php)
        sudo apt-get update
        sudo apt-get install -y php php-cli php-zip php-xml php-mbstring php-curl php-bcmath php-gd php-xmlrpc php-soap php-intl php-sqlite3 php-all-dev php-common
        ;;
    bun)
        curl -fsSL https://bun.sh/install | bash
        ;;
    zip)
        sudo apt-get install -y zip
        ;;
    esac
}

for dep in "${DEPENDENCIES[@]}"; do
    if ! command -v "$dep" &>/dev/null; then
        echo "Error: $dep is not installed, installing..." >&2
        install_dep "$dep"
    fi
done

[[ -f .env.example ]] && mv .env.example .env
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize
php artisan migrate --force --no-interaction
bun install --no-cache --no-save
bun run build

cp -rf public public_html
rm -rf node_modules \
    resources/js \
    resources/css \
    database/migrations \
    .editorconfig \
    .gitattributes \
    .gitignore \
    .prettierignore \
    .prettierrc \
    artisan \
    bun.lock \
    composer.lock \
    components.json \
    eslint.config.js \
    package.json \
    package-lock.json \
    phpunit.xml \
    tsconfig.json \
    vite.config.ts

zip -rqq "$1" . -x "ci-build.sh" ".git/*" ".github/*"
