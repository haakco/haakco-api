#!/usr/bin/env bash
env > /site/logs/initialiseBG.env

export LV_DO_CACHING=${LV_DO_CACHING:-"FALSE"}
export CRONTAB_ACTIVE=${CRONTAB_ACTIVE:-"FALSE"}
export LVENV_APP_ENV=${LVENV_APP_ENV:-"dev"}

if [[ "${LVENV_APP_ENV}" = "production" ]]; then
  composer install --no-ansi --no-suggest --prefer-dist --no-progress --no-interaction \
    --optimize-autoloader --no-dev
else
  composer install --no-ansi --no-suggest --prefer-dist --no-progress --no-interaction \
    --optimize-autoloader
fi

#composer clear

if [[ "${CRONTAB_ACTIVE}" = "TRUE" ]]; then
  echo "CRONTAB_ACTIVE ENABLED Clearing schedule cache"
  ./artisan schedule:cache:clear
fi

./artisan config:clear
./artisan responsecache:clear
./artisan package:discover
./artisan route:clear

if [[ "${LV_DO_CACHING}" = "TRUE" ]]; then
  echo "LV_DO_CACHING ENABLED"
  ./artisan config:cache
  ./artisan route:cache
  ./artisan view:cache
fi

#./artisan passport:keys

#./artisan l5-swagger:generate
#touch /site/web/storage/api-docs/.gitkeep
