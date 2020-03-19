#!/usr/bin/env bash
sed -itmp -E \
  -e 's#App\\Models\\Role#Spatie\\Permission\\Models\\Role#' \
  app/Models/*.php

rm -rf app/Models/*.phptmp
