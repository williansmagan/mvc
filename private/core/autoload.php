<?php
spl_autoload_register(function($className) {
    require $filename = '../private/model/' . ucfirst($className) . '.php';
});

require_once 'config.php';
require_once 'function.php';
require_once 'Database.php';
require_once 'Model.php';
require_once 'Controller.php';
require_once 'App.php';
