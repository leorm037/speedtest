# SPEEDTEST

## Instalação Apache2 e PHP-FPM

### PHP 8.2

```
sudo wget -qO /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
```

### Apache 2 e PHP-FPM

```
sudo apt install apache2 libapache2-mod-fcgid
sudo apt install php php-fpm php-common php-xml php-intl php-mbstring php-mcrypt curl php-curl php-zip composer
sudo a2enmod actions fcgid alias proxy_fcgi mpm_event setenvif
sudo a2enconf php8.2-fpm
sudo systemctl restart apache2

```

### MariaDB

```
sudo apt install mariadb-server php-mysql
```

## Instalação Composer

https://getcomposer.org/download/

```
cd /opt
sudo mkdir composer
cd composer
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo ln -s /opt/composer/composer.phar /usr/local/bin/composer
```

## Instalação Speedtest

https://www.speedtest.net/apps/cli

```
curl -s https://packagecloud.io/install/repositories/ookla/speedtest-cli/script.deb.sh | sudo bash
sudo apt install speedtest
sudo speedtest
```

## Tradução
```
php bin/console translation:extract --force --dump-messages --format=yaml --sort=asc pt_BR
```

## Gráfico Speedtest

https://github.com/leorm037/speedtest

```
mkdir ~/git
cd ~/git
git clone https://github.com/leorm037/speedtest.git
cd speedtest
composer update
cp .env.prod .env.prod.local
composer dump-env prod
composer install --no-dev --optimize-autoloader
sudo mysql < database/speedtest.sql
sudo cp -R ~/git/speedtest /var/www
sudo chown -R www-data: /var/www/speedtest/
sudo php /var/www/speedtest/bin/console speedtest:register
sudo cp ~/git/speedtest/cron.daily/speedtest-register /etc/cron.daily
```

> http://endereço do raspberry pi/speedtest/

http://localhost/speedtest

## Favicon

https://favicon.io/favicon-converter/

