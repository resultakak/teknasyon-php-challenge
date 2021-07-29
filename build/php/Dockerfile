FROM php:7.4-fpm

ARG PSR_VERSION=1.0.1
ARG PHALCON_VERSION=4.1.0
ARG PHALCON_EXT_PATH=php7/64bits
ARG INSTALL_VERSION=4.0.0

ARG user=sail
ARG uid=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
    ${PHPIZE_DEPS} \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpcre3-dev \
    libz-dev \
    libmemcached-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    bcmath \
    ctype \
    dom \
    json \
    iconv \
    mbstring \
    pdo \
    pdo_mysql \
    session \
    simplexml \
    xml \
    exif \
    pcntl \
    gd \
    xmlwriter

RUN pecl install memcached xdebug redis \
	&& docker-php-ext-enable memcached xdebug redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN set -xe && \
        # Download PSR, see https://github.com/jbboehr/php-psr
        curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
        # Download Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
            ${PWD}/php-psr-${PSR_VERSION} \
            ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} \
        && \
        # Remove all temp files
        rm -r \
            ${PWD}/v${PSR_VERSION}.tar.gz \
            ${PWD}/php-psr-${PSR_VERSION} \
            ${PWD}/v${PHALCON_VERSION}.tar.gz \
            ${PWD}/cphalcon-${PHALCON_VERSION} \
        && \
        php -m

RUN curl -LOs https://github.com/phalcon/phalcon-devtools/releases/download/v${INSTALL_VERSION}/phalcon.phar
RUN chmod +x phalcon.phar; mv phalcon.phar /usr/local/bin/phalcon
