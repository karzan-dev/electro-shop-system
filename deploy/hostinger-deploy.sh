#!/bin/bash
# Auto-deploy for hardymobile.de on Hostinger.
# Runs every minute from an hPanel cron job:
#   /bin/bash /home/u640945903/domains/hardymobile.de/mobileHardy/deploy/hostinger-deploy.sh
# It pulls the `production` branch (built by .github/workflows/deploy.yml) and,
# only when there is a new build, updates the code, runs migrations and copies
# the public assets into public_html. Uploaded images (images/, uploads/),
# public_html/index.php and .htaccess are never touched.
set -euo pipefail
export PATH="/usr/local/bin:/usr/bin:/bin:$PATH"

APP="$HOME/domains/hardymobile.de/mobileHardy"
WEB="$HOME/domains/hardymobile.de/public_html"
LOG="$HOME/deploy-hardymobile.log"
STATE="$HOME/.deploy-hardymobile.sha"

exec 9>"$HOME/.deploy-hardymobile.lock"
flock -n 9 || exit 0

cd "$APP"
git fetch -q origin production
NEW=$(git rev-parse origin/production)
OLD=$(cat "$STATE" 2>/dev/null || echo none)
[ "$NEW" = "$OLD" ] && exit 0

{
    echo "=== $(date '+%F %T') deploying ${NEW:0:7} (was ${OLD:0:7})"
    git reset -q --hard "$NEW"

    if [ "$OLD" = none ] || ! git diff --quiet "$OLD" "$NEW" -- composer.lock; then
        # Keep dev packages: the cached package list still loads them (--no-dev broke the site once).
        composer install --no-interaction --prefer-dist --optimize-autoloader
    fi

    php artisan migrate --force
    rsync -a --delete "$APP/public/build/" "$WEB/build/"
    rsync -a --exclude=/index.php --exclude=/.htaccess --exclude=/images --exclude=/uploads --exclude=/build --exclude=/... "$APP/public/" "$WEB/"
    php artisan optimize:clear

    echo "$NEW" > "$STATE"
    echo "=== done"
} >>"$LOG" 2>&1; exit 0  # exit on the same line: git reset may have rewritten this file
