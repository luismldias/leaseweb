FROM  php:8.1-apache

RUN echo "Running dockerfile"

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt

RUN apt-get update &&  apt-get install -y libzip-dev zip && docker-php-ext-install zip

RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath 

RUN apt-get update && apt-get install -y zip unzip git nano iputils-ping

RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev && rm -rf /var/lib/apt/lists/*2

RUN docker-php-ext-install gd

RUN export COMPOSER_HOME=/usr/local/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 


#Make terminal act as expected 
RUN ["rm","/bin/sh"]
RUN ["ln", "-s", "/bin/bash", "/bin/sh"]





    
