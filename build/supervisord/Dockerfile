FROM resultakak/php:latest

RUN apt-get update && \
    apt-get install -y supervisor && \
    apt-get clean

RUN mkdir -p /var/log/supervisor

COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

EXPOSE 8089

WORKDIR /var/www/worker

CMD ["supervisord","-c","/etc/supervisor/conf.d/laravel-worker.conf"]
