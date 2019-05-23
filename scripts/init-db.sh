#!/bin/bash -eu
set -o pipefail
# Include pretty printing for logs 
# This library provides error, log, and success functions
. $(cd $(dirname "$0"); pwd)/lib-logging.sh
trap "error 'DATABASE SETUP FAILED'" 0

USER=webdiplomacy
ADMIN_PASS=Admin2015
USER_PASS=$USER
ser=mysql

log "Starting MySql"

service mysql start

log "Creating database"
mysql -u root --password="$ADMIN_PASS" -h localhost <<-EOSQL
  CREATE DATABASE IF NOT EXISTS webdiplomacy;
  GRANT ALL ON webdiplomacy.* TO '$USER' IDENTIFIED BY '$USER_PASS'
EOSQL

log "Initial install v1.0"
cat /db_install/install.sql | mysql -u "$USER" --password="$USER_PASS" webdiplomacy

trap - 0

success "Database install complete"
