FROM php:8.2-fpm

# 更新並安裝系統依賴、Composer
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libbz2-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    zip \
    # 這裡是安裝 intl 所需的依賴
    libicu-dev \
    && docker-php-ext-install \
    bcmath \
    mbstring \
    pdo \
    pdo_mysql \
    mysqli \
    xml \
    # 安裝 intl 擴展
    intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    # 安裝 Composer
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 添加 apt-get clean && rm -rf /var/lib/apt/lists/*（避免 apt 缓存冗余，减少镜像大小）
# 使用 --no-install-recommends（避免安装不必要的软件包，减小体积）

# 設置工作目錄
WORKDIR /var/www/html

# 複製應用代碼
COPY ./www /var/www/html

# 設置適當的權限
RUN chown -R www-data:www-data /var/www/html