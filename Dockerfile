FROM phpdockerio/php73-fpm:latest
ENV ACCEPT_EULA=Y

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        wget \
        unzip \
        xdg-utils \
        php-common \
        php7.3-bcmath \
        php7.3-curl \
        php7.3-gd \
        php7.3-intl \
        php7.3-json \
        php7.3-mbstring \
        php7.3-opcache \
        php7.3-xml \
        php7.3-zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    # Create the /var/www folder and ensure we have the appropriate
    # permissions on it because we'll be running as www-data, not root
    && mkdir -p /var/www \
    && chown www-data:www-data /var/www

# Set up composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# This is necessary to let php-fpm run as www-data instead of root
RUN usermod -u 1000 www-data

WORKDIR /var/www/metrics/
