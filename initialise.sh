#!/usr/bin/env bash
env > /site/logs/initialise.env
export HOME=/site

export LV_DO_CACHING=${LV_DO_CACHING:-"FALSE"}
export CRONTAB_ACTIVE=${CRONTAB_ACTIVE:-"FALSE"}

cd /site/web/ || exit

ln -sf /usr/share/GeoIP  /site/web/storage/GeoIP

#./artisan passport:keys

./intialiseBG.sh &
