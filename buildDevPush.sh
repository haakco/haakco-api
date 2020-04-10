#!/usr/bin/env bash
IMAGE_NAME=haakco/haakco-api
docker build --pull --rm -t "${IMAGE_NAME}" .
docker push "${IMAGE_NAME}"
