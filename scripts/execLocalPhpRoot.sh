#!/usr/bin/env bash
docker exec -it $(docker ps  | grep haakco-laravel_laravel | awk '{print $1}') /bin/bash
