#!/usr/bin/env bash
cd ../haakco-docker/docker-ubuntu1910-php74 || exit
git pull
cp -rf ../../haakco-api/composer.json ./files/composer_cache/composer.json
cp -rf ../../haakco-api/composer.lock ./files/composer_cache/composer.lock
git commit -a -m 'Update composer files'
git push
