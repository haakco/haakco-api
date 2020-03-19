#!/usr/bin/env bash
if [ -z "${DB_HOST}" ]
then
  echo -n "DB host: " ; read -r DB_HOST
fi

if [ -z "${DB_USER}" ]
then
  echo -n "DB username: " ; read -r DB_USER
fi

if [ -z "${DB_NAME}" ]
then
  echo -n "DB name: " ; read -r DB_NAME
fi

if [ -z "${DB_PWD}" ]
then
  echo -n "DB password: " ; stty -echo ; read -r PGPASSWORD ; stty echo ; echo
else
  PGPASSWORD="${DB_PWD}"
fi

export PGPASSWORD

pg_dump \
  --clean \
  --host="${DB_HOST}" \
  --username="${DB_USER}" \
  --dbname="${DB_NAME}" \
  | xz -z -c -T0 -9e > haakco.sql.xz
