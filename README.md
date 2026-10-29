# Hardy Phone (hardymobile.de)

Laravel 12 shop management system (sales, stock, debts, reports).

## Deploy

Push to `main` and the change is live on https://hardymobile.de within ~2 minutes:

1. GitHub Actions (`.github/workflows/deploy.yml`) builds the CSS/JS and publishes the result to the `production` branch.
2. A Hostinger cron job runs `deploy/hostinger-deploy.sh` every minute. When `production` has a new build it updates the code, runs migrations and copies `public/` into `public_html` (uploaded images are never touched).

The deploy log is `~/deploy-hardymobile.log` on the server.
Do not edit files directly on the server: the next deploy overwrites them. Edit locally, then push.
