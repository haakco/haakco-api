#!/usr/bin/env bash
IMAGE_NAME=haakco/haakco-api-dev
docker build --rm --file Dockerfile.dev -t "${IMAGE_NAME}" .
