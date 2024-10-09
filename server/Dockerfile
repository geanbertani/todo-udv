# Imagem do PHP 8.2 Apache para MacBook M1
FROM arm64v8/php:8.2-apache

# Variaveis de ambiente
ENV TIMEZONE=America/Sao_Paulo
ENV XDEBUG_VERSION=xdebug-3.2.0

# Configura a TimeZone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# Atualiza e Instala as ferramentas e bibliotecas do Sistema Operacional
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        curl \
        libzip-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libfreetype6-dev \
        libwebp-dev \
        libmcrypt-dev \
        libonig-dev \
        libicu-dev

# Configura Apache
RUN a2enmod ssl && \
    a2enmod rewrite && \
    a2enmod autoindex
RUN mkdir -p /etc/apache2/ssl   

# Instala as extensões PHP
RUN set -eux; \
    docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        mbstring \
        intl \
        exif \
        bcmath \        
        iconv; \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp; \
    docker-php-ext-install -j$(nproc) gd;

# Copia arquivos para o Container
COPY ./ssl/*.pem /etc/apache2/ssl/
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./php/php.ini /usr/local/etc/php/

# Instala e Configura o XDebug
RUN pecl install -o ${XDEBUG_VERSION} \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Instala o Composer PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Diretorio dentro do container
WORKDIR /var/www/html

# Libera as portas
EXPOSE 80 443

# Limpa o cache dos pacotes do Linux
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*   
