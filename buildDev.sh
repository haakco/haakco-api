#!/usr/bin/env bash
IMAGE_NAME=haakco/haakco-api-dev
docker build --rm -t "${IMAGE_NAME}" .
