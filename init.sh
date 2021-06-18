#!/bin/sh

echo init cmd

chmod a+w -R storage bootstrap/cache

php artisan vendor:publish --force --tag=oa-app
php artisan migrate --force
php artisan tenancy:migrate --force
php artisan tenancy:run init:permission
php artisan tenancy:run check:aeskey
php artisan tenancy:run init:role-contain-key
php artisan route:cache

/usr/local/bin/php artisan schedule:run >> runlog
