FROM linode/lamp
LABEL maintainer="timothy.l.jones@gmail.com"

# Finish setting up server
RUN apt-get update
RUN apt-get install -y php5-mysql php5-gd libgd2-xpm-dev
RUN apt-get install -y libfreetype6
RUN apt-get install -y wget
RUN rm /var/www/example.com/public_html/index.html

# Add webDiplomacy harness
ADD scripts /scripts
ADD gameCron /etc/cron.d/hello-cron
RUN chmod 0644 /etc/cron.d/hello-cron
RUN crontab /etc/cron.d/hello-cron

# install the database
ADD webDiplomacy/install /db_install
RUN /scripts/init-db.sh
RUN /scripts/variants-fix.sh

CMD  ./scripts/docker-entrypoint.sh
