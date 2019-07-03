#!/bin/bash -eu
# Include pretty printing for logs
# This library provides error, log, and success functions
. $(cd $(dirname "$0"); pwd)/lib-logging.sh

trap "error 'Failed to start webDiplomacy Development Server'" 0

log "Starting services"

chgrp -R www-data /var/www
chmod -R g+rw /var/www

cron gameCron

service apache2 start
service mysql start

./scripts/update-db.sh

log "Confirming source is mounted"

if [ ! -f /var/www/example.com/public_html/index.php ]; then
  error "index.php is missing - perhaps you didn't mount the webDiplomacy files?"
  exit
fi

if [ ! -f /var/www/example.com/public_html/config.php ]; then
  error "config.php is missing - make sure you copy it from the root of this repository"
  exit
fi

trap - 0

success_banner "webDiplomacy is ready for development"

if [ ! -z ${WEBDIP_PORT+x} ] ; then
  info "listening on http://localhost:$WEBDIP_PORT" 
  info "You can change this by setting WEBDIP_PORT before calling ./start-server.sh"
fi
tail -f /dev/null

