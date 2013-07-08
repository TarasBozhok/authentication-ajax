ZendSkeletonApplication
=======================

Introduction
------------

This is a simple, skeleton application using the ZF2 MVC layer and module
systems. Extra module User provide authentication.


Additional information
----------------------

There are 2 controllers in User module
AuthController responsible authentication check
UserController responsible for registration and authentication

To provide authentication extra service AuthService was added

Configuration
-------------

1) php composer.phar install

2) Setup your database connection
    speroteck/config/autoload/local.php

3) Create users table
    CREATE TABLE users (
     id int(11) NOT NULL auto_increment,
     name varchar(100) NOT NULL,
     login varchar(100) NOT NULL,
     password varchar(100) NOT NULL,
     PRIMARY KEY (id)
    );

4) create VirtualHost