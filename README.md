# MediaArea-Website

[![Build Status](https://travis-ci.org/MediaArea/MediaArea-Website.svg?branch=master)](https://travis-ci.org/MediaArea/MediaArea-Website)

# How to install

## Dependencies

* A web server (tested on Apache 2.4)
    * mod_rewrite is recommended
* PHP (tested on version 7.0 and 7.1)
    * Mandatory packages for Debian-like distributions : `sudo apt-get install libapache2-mod-php7.0 php7.0-cli php7.0-intl php7.0-curl php7.0-opcache php7.0-mysql`
    * Mandatory packages for RedHat-like distributions : `sudo dnf install php php-cli php-intl php-mbstring php-pdo php-process php-xml php-opcache php-mysqlnd`
    * date.timezone parameter should be set in your php.ini (both cli and apache module)
* MySQL >= 5.1
* [Composer](https://getcomposer.org/download/)

## Get sourcecode

### From git

Clone MediaArea-Website repository
```
git clone https://github.com/MediaArea/MediaArea-Website.git
```
## Install

### MySQL

Create a user and a datable, give the user the all rights to this database.
```
CREATE USER '<USER>'@'<HOST>' IDENTIFIED BY '<PASSWORD>';
GRANT ALL ON `<DB>`.* TO '<USER>'@'<HOST>';
CREATE DATABASE IF NOT EXISTS `<DB>`;
```

### Dependencies

Get dependencies with composer
```
cd YOUR_PATH/MediaArea-Website/
composer install
```
You'll get some configuration questions, you can use [these fake values](blob/master/app/config/parameters.yml.travis) if you don't care about the payments.

### SQL tables and assets

```
php bin/console doctrine:migrations:migrate --env=prod --no-interaction
php bin/console assetic:dump --env=prod
```

### Apache

Add a vhost to access MediaArea-Website, like this minimal example :
```
<VirtualHost *:80>
    ServerName WWW.YOURWEBSITE.COM
    DocumentRoot "YOUR_PATH/MediaArea-Website/web/"
    <Directory "YOUR_PATH/MediaArea-Website/web/">
        AllowOverride All
        Options -Indexes
        <IfModule mod_authz_core.c>
          # Apache 2.4
            Require all granted
        </IfModule>
        <IfModule !mod_authz_core.c>
          # Apache 2.2
            Order allow,deny
            allow from all
        </IfModule>
    </Directory>
</VirtualHost>

```
Allow apache user to write in cache and log directory, some methods are explain in [Symfony documentation](https://symfony.com/doc/current/setup/file_permissions.html)

# Doc

## Translations

Translations are stored is XML format [here](https://github.com/MediaArea/MediaArea-Website/blob/master/app/Resources/translations/) one file per language

## Template

Templates are in twig format, they are available [here](https://github.com/MediaArea/MediaArea-Website/tree/master/src/AppBundle/Resources/views)

## Coding standard

MediaArea-Website follow [PSR1](http://www.php-fig.org/psr/psr-1/) and [PSR2](http://www.php-fig.org/psr/psr-2/) standard  
The source code is analyzed with [PHP Mess Detector](https://phpmd.org/) with the rules in [phpmd.xml](https://github.com/MediaArea/MediaArea-Website/blob/master/phpmd.xml) and [PHP-CS-Fixer](http://cs.sensiolabs.org/) with PSR1 and PSR2 rules

## Cache

Remind to clear the cache after a modification :
```
php bin/console cache:clear --env=prod
```
