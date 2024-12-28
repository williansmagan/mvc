<?php
session_start();

define('ROOTHPATH', __DIR__ . DIRECTORY_SEPARATOR);

$minPHPVersion = '8.0';
if(phpversion() < $minPHPVersion) {
    die('Your PHP Version must be ' . $minPHPVersion . ' or higher to run this framework');
}

require_once '../private/core/autoload.php';
$app = new Core\App;
$app->loadController();