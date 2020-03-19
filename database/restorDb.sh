#!/usr/bin/env bash
DATE=$(date +"%Y%m%d%H%M")

if [ -z "${DB_RESTORE_FILE_NAME}" ]
then
  echo -n "DB sql file: " ; read -r DB_RESTORE_FILE_NAME
fi

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

DB_BACKUP_FILE="haakco.${DATE}.sql.xz"
echo "Backing up db just incase"
mkdir -p "./database/backup/"

pg_dump \
  --clean \
  --host="${DB_HOST}" \
  --username="${DB_USER}" \
  --dbname="${DB_NAME}" \
  | xz -z -c -T0 -9e > "./database/backup/${DB_BACKUP_FILE}"

xz \
  --decompress \
  --keep \
  --stdout \
  "${DB_RESTORE_FILE_NAME}" \
  | \
psql \
  --host="${DB_HOST}" \
  --username="${DB_USER}" \
  --dbname="${DB_NAME}"
