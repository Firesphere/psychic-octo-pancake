#!/bin/sh

nohup chown -R www-data:www-data /var/www/html/public/assets &
nohup php vendor/silverstripe/framework/cli-script.php dev/build flush=all &

caddy run -c /etc/caddy/Caddyfile
