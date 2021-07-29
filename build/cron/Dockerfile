FROM php:7.4-cli

RUN apt-get update && \
    apt-get install -y cron && \
    apt-get clean

COPY crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab

RUN touch /var/log/cron.log

CMD ["crond", "-f"]
