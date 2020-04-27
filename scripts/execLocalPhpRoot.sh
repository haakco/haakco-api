#!/usr/bin/env bash
docker exec \
  -it \
  "$(docker ps --filter "name=laravel-api" --filter "status=running" --filter 'name=haakco/haakco-api*' | grep -v 'CONTAINER ID' | head -n 1 |  awk '{print $1}')" \
  /bin/bash

