#!/usr/bin/env bash
docker exec --user web -it $(docker ps  | grep haakco-laravel_laravel | awk '{print $1}') /bin/bash
