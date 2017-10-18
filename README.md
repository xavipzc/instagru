# Instagru

## Description

This is an Instagram-like's website from scratch, first project right after the Piscine PHP
(2 intensive weeks to learn PHP, SQL, JavaScript, CSS, HTML).
Users can create and manage there account, do photo montage using the webcam and share it to the community.
Frameworks are forbidden.

### Objectives

* User management
* Auth management
* Emailing
* Security

### Skills

* Web
* DB & Data
* Security

### Installation

Clone the project to your web server

``` bash
$> git clone https://github.com/xavipzc/instagru.git
```

You may need to configure the config/database.php file

```
<?php

$DB_NAME = 'instagru';
$DB_DSN = 'mysql:host=localhost';
$DB_USER = 'root';
$DB_PASSWORD = 'root';

?>
```

Go to `http://localhost/instagru/config/setup.php` to initialize the db.
It's ready to use, create your account !

## Authors

Xavier Pouzenc
xpouzenc@student.42.fr
