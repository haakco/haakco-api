#!/usr/bin/env bash
./vendor/bin/phpcbf --report=full --standard=PSR12 --encoding=utf-8 ./app || true
./vendor/bin/phpcbf --report=full --standard=PSR12 --encoding=utf-8 -q ./routes/ || true
./vendor/bin/phpcbf --report=full --standard=PSR12 --encoding=utf-8 -q ./config/ || true
