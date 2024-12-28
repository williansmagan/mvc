<?php
defined('ROOTHPATH') OR exit('Access denied');

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, "pt-BR.UTF-8");

$debug = 1;
if($debug == 1) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('SITE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME']);
define('SITE_NAME', 'MVC Framework');

if($_SERVER['SERVER_NAME'] == 'localhost') {
    define('TYPE_DB', 'mysql');
    define('HOST_DB', 'db');
    define('PORT_DB', '3306');
    define('NAME_DB', 'mvc');
    define('USER_DB', 'root');
    define('PASS_DB', 'root');
    define('CHAR_DB', ';charset=utf8');
    define('OPT_DB', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',));   
} else {
    define('TYPE_DB', 'mysql');
    define('HOST_DB', 'localhost');
    define('PORT_DB', '3306');
    define('NAME_DB', '');
    define('USER_DB', '');
    define('PASS_DB', '');
    define('CHAR_DB', ';charset=utf8');
    define('OPT_DB', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',));   
}