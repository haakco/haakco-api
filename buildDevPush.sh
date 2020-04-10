#!/usr/bin/env bash
IMAGE_NAME=haakco/haakco-api
docker build --pull --file Dockerfile.dev --rm -t "${IMAGE_NAME}" .
docker push "${IMAGE_NAME}"
