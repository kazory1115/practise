PHP 　 CodeIgniter docker 環境建置

提供以下 docker 常見指令

依 docker-compose.yml 文件下載
docker compose up -d

清緩存
docker system prune -af

全部重建
docker-compose down
docker-compose up -d
打開
docker-compose start

關閉
docker-compose stop

執行進入容器的命令

docker compose exec app bash

更新現有重建
docker-compose build php
docker-compose up -d

更新包管理器
apt update

安裝 vim
apt-get update
apt-get install vim

提升權限
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
