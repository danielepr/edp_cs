Big-Sticky-Notes
================
    ______ _         _____                 _
    | ___ (_)       |  ___|               | |
    | |_/ /_  __ _  | |__  _ __ ___  _ __ | | ___  _   _  ___  ___
    | ___ \ |/ _` | |  __|| '_ ` _ \| '_ \| |/ _ \| | | |/ _ \/ _ \
    | |_/ / | (_| | | |___| | | | | | |_) | | (_) | |_| |  __/  __/
    \____/|_|\__, | \____/|_| |_| |_| .__/|_|\___/ \__, |\___|\___|
              __/ |                 | |             __/ |
             |___/                  |_|            |___/

Introduction
------------
As an Internet Payment Service Provider (IPSP) we offer our customers (merchants) an API to initiate 

online payments (via credit card, debit card, PayPal, etc). In this Case Study we would like you to act as 

a merchant and implement a small checkout page for credit card payments.

Installation
------------

Using Composer (recommended)
----------------------------
Clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Database
--------
Create Database and run the following query to create the table and insert
sample data.

    -- -----------------------------------------------------
    -- Table `ebpayments`.`payments`
    -- -----------------------------------------------------
    DROP TABLE IF EXISTS `ebpayments`.`payments` ;
    CREATE TABLE IF NOT EXISTS `ebpayments`.`payments` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `payer_firstname` VARCHAR(255) NULL ,
    `payer_lastname` VARCHAR(255) NULL ,
    `cc_number` VARCHAR(16) NULL ,
    `amount` DECIMAL(13,2) NULL ,
    `currency` VARCHAR(3) NULL ,
    `cc_CVV` VARCHAR(4) NULL ,
    `cc_expiration_month` TINYINT(2) NULL ,
    `cc_expiration_year` SMALLINT(4) NULL ,
    `created` TIMESTAMP NOT NULL ,
    PRIMARY KEY (`id`) ,
    UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
    ENGINE = MyISAM;
    -- -----------------------------------------------------
    -- End table `ebpayments`.`payments`
    -- -----------------------------------------------------

open config/autoload/global.php and config/autoload/local.php and configure
your Database credentials.

if local.php is missing duplicate local.php.dist and modify the file

    // /config/autoload/local.php
    return array(
        'db' => array(
            'username' => 'DB_User_Name',
            'password' => 'DB_Password',
        ),
    );

Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!
