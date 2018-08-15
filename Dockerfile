FROM resin/rpi-raspbian:jessie
MAINTAINER Pavel Batanov <pavel@batanov.me>

RUN echo "deb http://mirrordirector.raspbian.org/raspbian/ stretch main contrib non-free rpi" > /etc/apt/sources.list.d/raspbian_nonfree.list

RUN echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu xenial main" > /etc/apt/sources.list.d/php7.list
RUN echo "deb-src http://ppa.launchpad.net/ondrej/php/ubuntu xenial main " >> /etc/apt/sources.list.d/php7.list

RUN gpg --keyserver keyserver.ubuntu.com --recv E5267A6C && gpg --export --armor E5267A6C | apt-key add -

RUN apt-get update
RUN apt-get install -y --no-install-recommends git zip vim curl

RUN apt-get install -y php7.0 php7.0-fpm php7.0-curl php7.0-fpm php7.0-json php7.0-cli php7.0-common php7.0-mbstring php7.0-opcache php7.0-mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN sed -Ei 's/^listen.*/listen = 9000/' /etc/php/7.0/fpm/pool.d/www.conf

RUN mkdir /run/php/
RUN service php7.0-fpm restart

ADD . /run/php/

WORKDIR /run/php/

EXPOSE 9000

CMD ["php-fpm7.0", "-F"]
