#!/bin/bash
set -e

until pg_isready -h postgres-primary -U postgres
do
  echo "Waiting for primary..."
  sleep 2
done

rm -rf /var/lib/postgresql/data/*

export PGPASSWORD=replica123

pg_basebackup \
  -h postgres-primary \
  -D /var/lib/postgresql/data \
  -U replicator \
  -Fp \
  -Xs \
  -P \
  -R

exec docker-entrypoint.sh postgres