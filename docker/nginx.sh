#!/usr/bin/env sh
set -eu

envsubst '${NGINX_APP_HOST}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

exec "$@"
