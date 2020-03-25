FROM haakco/ubuntu1910-php74-haakco-composer-cache

USER web

ADD --chown=web:web . /site/web

WORKDIR /site/web

RUN composer install --no-ansi --no-suggest --no-scripts --prefer-dist --no-progress --no-interaction \
      --optimize-autoloader

USER root

RUN find /usr/share/GeoIP -not -user web -execdir chown "web:" {} \+ && \
    find /site/web -not -user web -execdir chown "web:" {} \+

HEALTHCHECK \
  --interval=30s \
  --timeout=30s \
  --retries=10 \
  --start-period=60s \
  CMD if [[ "$(curl -f http://127.0.0.1/api/v1/test/basic_system | jq -e . >/dev/null 2>&1)" != "0" ]]; then exit 1; else exit 0; fi


