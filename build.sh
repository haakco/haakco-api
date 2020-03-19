#!/usr/bin/env bash
IMAGE_NAME=haakco/haakco-api
docker build --rm -t "${IMAGE_NAME}" .
